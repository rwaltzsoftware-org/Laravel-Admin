<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Common\Traits\MultiActionTrait;

use App\Models\FAQModel;  
use App\Common\Services\LanguageService;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;


use Sentinel;
use Validator;
use Flash;
 
class FAQController extends Controller
{
    use MultiActionTrait;

    public function __construct(FAQModel $faq,
                                LanguageService $langauge,
                                ActivityLogsModel $activity_logs)
    {        
        $this->arr_view_data     =   [];
        
        $this->FAQModel          =   $faq;
        $this->BaseModel         =   $this->FAQModel;
        $this->ActivityLogsModel = $activity_logs;


        /*For activity log*/
        $this->obj_data    = Sentinel::getUser();
        $this->first_name  = $this->obj_data->first_name;
        $this->last_name   = $this->obj_data->last_name;
        
        
        $this->module_title      =   "FAQ's";
        $this->LanguageService   =   $langauge;
        $this->module_url_path   =   url(config('app.project.admin_panel_slug')."/faq");
        $this->module_view_folder=   "admin.faq";
    }   
 
    public function index()
    {
        $arr_lang = array();
        $arr_data = array();
        $obj_data = $this->BaseModel->get();
        $arr_lang = $this->LanguageService->get_all_language();

        if(sizeof($obj_data)>0)
        {
            foreach ($obj_data as $key => $data) 
            {
                $arr_tmp = array();
                // Check Language Wise Transalation Exists
                foreach ($arr_lang as $key => $lang) 
                {
                    $arr_tmp[$key]['title']     = $lang['title'];
                    $arr_tmp[$key]['is_avail']  = $data->hasTranslation($lang['locale']);
                }    
                    $data->arr_translation_status = $arr_tmp;
        // Call to hasTranslation method of object is triggering translations so need to unset it 
                    unset($obj_data->translations);
            }
        }

        if($obj_data != FALSE)
        {
            $arr_data = $obj_data->toArray();
        }

        
        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['page_title']      = "Manage ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }


    public function create()
    {
        $this->arr_view_data['arr_lang']        = $this->LanguageService->get_all_language();  
        $this->arr_view_data['page_title']      = "Create ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }


    /*
    | store() : Stores newly created FAQ.
    | auther : Paras Kale
    | Date   : 05/11/2016
    | @param  \Illuminate\Http\Request  $request
    | @return \Illuminate\Http\Response
    */

    public function store(Request $request)
    {  
        //$form_data = array();

        /* English Required */
        $arr_rules['question_en'] = "required";        
        $arr_rules['answer_en']   = "required";        
         
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }   

        //$form_data = $request->all();

        /* Check if location already exists with given translation */
        $does_exists = $this->BaseModel
                            ->whereHas('translations',function($query) use($request)
                                        {
                                            $query->where('locale','en')
                                                  ->where('question',$request->input('question_en'));      
                                        })
                            ->count();   
                      
        if($does_exists)
        {
            Flash::error(str_singular($this->module_title).' Already Exists.');
            return redirect()->back();
        }


        /* Insert into Location Table */

        $arr_data = array();
        $arr_data['is_active'] = 1;

        $entity = $this->BaseModel->create($arr_data);

        if($entity)      
        {
            $arr_lang =  $this->LanguageService->get_all_language();      
         
            /* insert record into translation table */
            if(sizeof($arr_lang) > 0 )
            {
                foreach ($arr_lang as $lang) 
                {            
                    $arr_data = array();
                    $question = $request->input('question_'.$lang['locale']);
                    $answer   = $request->input('answer_'.$lang['locale']);

                    if( (isset($question) && $question != '') && (isset($answer) && $answer != '') )
                    { 
                        $translation = $entity->translateOrNew($lang['locale']);

                        $translation->faq_id    = $entity->id;
                        $translation->question  = $question;
                        $translation->answer    = $answer;
                        $translation->save();
                        /*-------------------------------------------------------
                        |   Activity log Event
                        --------------------------------------------------------*/
                            $arr_event                 = [];
                            $arr_event['ACTION']       = 'ADD';
                            $arr_event['MODULE_TITLE'] = $this->module_title;

                            $this->save_activity($arr_event);
                        /*----------------------------------------------------------------------*/
                        Flash::success(str_singular($this->module_title).' Created Successfully');
                    }
                }//foreach 

            } //if
            else
            {
                Flash::error('Problem Occured, While Creating '.str_singular($this->module_title));
            }
        }

        if($entity)
        {
            $enc_id = base64_encode($entity->id);
            return redirect($this->module_url_path.'/edit/'.$enc_id);
        }
        else
        {    
            return redirect()->back();
        }
    }

    public function edit($enc_id)
    {
        $id       = base64_decode($enc_id);
        $arr_lang = $this->LanguageService->get_all_language();
        $obj_data = $this->BaseModel->where('id', $id)->with(['translations'])->first();
        $arr_data = [];

        if($obj_data)
        {
           $arr_data = $obj_data->toArray();
           /* Arrange Locale Wise */
           $arr_data['translations'] = $this->arrange_locale_wise($arr_data['translations']);
        }

        $this->arr_view_data['edit_mode']       = TRUE;
        $this->arr_view_data['enc_id']          = $enc_id;
        $this->arr_view_data['arr_lang']        = $this->LanguageService->get_all_language();  
        $this->arr_view_data['arr_data']        = $arr_data; 
        $$this->arr_view_data['page_title']      = "Edit ".str_singular( $this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.edit',$this->arr_view_data);
    }


    public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);

        $arr_rules = array();
        /* English Required */
        $arr_rules['question_en'] = "required";        
        $arr_rules['answer_en']   = "required";       
         
        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        

        /* Get All Active Languages */ 
        $arr_lang = $this->LanguageService->get_all_language();  

        /* Retrieve Existing FAQ*/
        $entity = $this->BaseModel->where('id',$id)->first();

        if(!$entity)
        {
            Flash::error('Problem Occured While Retriving '.str_singular($this->module_title));
            return redirect()->back();   
        }

        /* Check if location type already exists with given translation */
        $does_exists = $this->BaseModel
                            ->where('id','<>',$id)
                            ->whereHas('translations',function($query) use($request)
                                        {
                                            $query->where('locale','en')
                                                  ->where('question',$request->input('question_en'));      
                                        })
                            ->count()>0;   
        if($does_exists)
        {
            Flash::error(str_singular($this->module_title).' Already Exists');
            return redirect()->back();
        }


        /* Insert Multi Lang Fields */

        if(sizeof($arr_lang) > 0)
        { 
            foreach($arr_lang as $i => $lang)
            {
                $question = $request->input('question_'.$lang['locale']);
                $answer   = $request->input('answer_'.$lang['locale']);

                if( (isset($question) && $question != '') && (isset($answer) && $answer != '') )
                {
                    /* Get Existing Language Entry */
                    $translation = $entity->getTranslation($lang['locale']);    
                    if($translation)
                    {
                        $translation->question  = $question;
                        $translation->answer    = $answer;
                        $translation->save();    
                    }  
                    else
                    {
                        /* Create New Language Entry  */
                        $translation = $entity->getNewTranslation($lang['locale']);
                        $translation->faq_id    = $id;
                        $translation->question  = $question;
                        $translation->answer    = $answer;
                        $translation->save();
                    } 
                }   
            }
            
        }
        /*-------------------------------------------------------
        |   Activity log Event
        --------------------------------------------------------*/
            $arr_event                 = [];
            $arr_event['ACTION']       = 'EDIT';
            $arr_event['MODULE_TITLE'] = $this->module_title;

            $this->save_activity($arr_event);
        /*----------------------------------------------------------------------*/

        Flash::success(str_singular($this->module_title).' Updated Successfully');

        return redirect()->back(); 
    }

    public function arrange_locale_wise(array $arr_data)
    {
        if(sizeof($arr_data)>0)
        {
            foreach ($arr_data as $key => $data) 
            {
                $arr_tmp = $data;
                unset($arr_data[$key]);

                $arr_data[$data['locale']] = $data;                    
            }

            return $arr_data;
        }
        else
        {
            return [];
        }
    }
}
