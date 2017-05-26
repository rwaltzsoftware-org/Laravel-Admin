<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Traits\MultiActionTrait;

use App\Common\Services\LanguageService;  
use App\Models\StaticPageModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;   

use Validator;
use Flash;
Use Sentinel;
 
class StaticPageController extends Controller
{
    use MultiActionTrait;
    
    public $StaticPageModel; 
    
    public function __construct(StaticPageModel $static_page,
                                LanguageService $langauge,
                                ActivityLogsModel $activity_logs)
    {      
        $this->StaticPageModel   = $static_page;
        $this->BaseModel         = $this->StaticPageModel;
        $this->ActivityLogsModel = $activity_logs;

        $this->obj_data          = Sentinel::getUser();
        $this->first_name        = $this->obj_data->first_name;
        $this->last_name         = $this->obj_data->last_name;
        
        $this->LanguageService   = $langauge;
        $this->module_title      = "CMS";
        $this->module_url_slug   = "static_pages";
        $this->module_url_path   = url(config('app.project.admin_panel_slug')."/static_pages");
        $this->theme_color       = theme_color();
    }


     /*
    | Index  : Display listing of Static Pages
    | auther : Paras Kale 
    | Date   : 13/02/2015
    | @return \Illuminate\Http\Response
    */ 
 
    public function index()
    {

        $arr_lang   =  $this->LanguageService->get_all_language();  

        $obj_static_page = $this->BaseModel->get();

        if($obj_static_page != FALSE)
        {
            $arr_static_page = $obj_static_page->toArray();
        }

        $this->arr_view_data['arr_static_page'] = $arr_static_page; 
        $this->arr_view_data['page_title']      = "Manage ".$this->module_title;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['theme_color']     = $this->theme_color;

       return view('admin.static_page.index',$this->arr_view_data);
    }



    public function create()
    {
        $this->arr_view_data['arr_lang']        = $this->LanguageService->get_all_language();
        $this->arr_view_data['page_title']     = "Create ".$this->module_title;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['theme_color']     = $this->theme_color;

        return view('admin.static_page.create',$this->arr_view_data);
    }


    public function store(Request $request)
    {
        $form_data = array();

        $arr_rules['page_title_en']     = "required";  
        $arr_rules['meta_keyword_en']   = "required"; 
        $arr_rules['meta_desc_en']      = "required";  
        $arr_rules['page_desc_en']      = "required";  

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
             return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    
        $form_data = $request->all();

        $arr_data = array();
        $arr_data['page_slug'] = str_slug($request->input('page_title_en'));
        $arr_data['is_active'] = 1;            
      
        
        $static_page    = $this->BaseModel->create($arr_data);

        $static_page_id = $static_page->id;

        /* Fetch All Languages*/
        $arr_lang =  $this->LanguageService->get_all_language();

        if(sizeof($arr_lang) > 0 )
        {
            foreach ($arr_lang as $lang) 
            {            
                $arr_data     = array();
                $page_title   = 'page_title_'.$lang['locale'];
                $meta_keyword = 'meta_keyword_'.$lang['locale'];
                $meta_desc    = 'meta_desc_'.$lang['locale'];
                $page_desc    = 'page_desc_'.$lang['locale'];

                if( isset($form_data[$page_title]) && $form_data[$page_title] != '')
                { 
                    $translation = $static_page->translateOrNew($lang['locale']);

                    $translation->page_title      = $form_data[$page_title];
                    $translation->meta_keyword    = $form_data[$meta_keyword];
                    $translation->meta_desc       = $form_data[$meta_desc];
                    $translation->page_desc       = $form_data[$page_desc];
                    $translation->static_page_id  = $static_page_id;

                    $translation->save();
                    
                    /*-------------------------------------------------------
                    |   Activity log Event
                    --------------------------------------------------------*/
                        $arr_event                 = [];
                        $arr_event['ACTION']       = 'ADD';
                        $arr_event['MODULE_TITLE'] = $this->module_title;

                        $this->save_activity($arr_event);
                    /*----------------------------------------------------------------------*/

                    Flash::success($this->module_title .' Created Successfully');
                }

            }//foreach

        } //if
        else
        {
            Flash::success('Problem Occurred, While Creating '.$this->module_title);
        }

        return redirect()->back();
    }



    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);

        
        $arr_lang = $this->LanguageService->get_all_language();      

        $obj_static_page = $this->BaseModel->where('id', $id)->with(['translations'])->first();

        $arr_static_page = [];

        if($obj_static_page)
        {
           $arr_static_page = $obj_static_page->toArray(); 

           /* Arrange Locale Wise */
           $arr_static_page['translations'] = $this->arrange_locale_wise($arr_static_page['translations']);
        }


        $this->arr_view_data['edit_mode'] = TRUE;
        $this->arr_view_data['enc_id']    = $enc_id;
        $this->arr_view_data['arr_lang']  = $this->LanguageService->get_all_language();
        
        $this->arr_view_data['arr_static_page'] = $arr_static_page;
        $this->arr_view_data['page_title']      = "Edit ".$this->module_title;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['theme_color']     = $this->theme_color;

        return view('admin.static_page.edit',$this->arr_view_data);  

    }

    public function update(Request $request, $enc_id)
    {
        $id        = base64_decode($enc_id);
        $arr_rules = array();

        $arr_rules['page_title_en']   = "required";
        $arr_rules['meta_keyword_en'] = "required";
        $arr_rules['meta_desc_en']    = "required";
        $arr_rules['page_desc_en']    = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $form_data = array();
        $form_data = $request->all(); 

         /* Get All Active Languages */ 
  
        $arr_lang = $this->LanguageService->get_all_language();

        $pages = $this->BaseModel->where('id',$id)->first();

        
         /* Insert Multi Lang Fields */

        if(sizeof($arr_lang) > 0)
        { 
            foreach($arr_lang as $i => $lang)
            {
                $translate_data_ary = array();
                $title = 'page_title_'.$lang['locale'];

                if(isset($form_data[$title]) && $form_data[$title]!="")
                {
                    /* Get Existing Language Entry */
                    $translation = $pages->getTranslation($lang['locale']);    
                    if($translation)
                    {
                        $translation->page_title    =  $form_data['page_title_'.$lang['locale']];
                        $translation->meta_keyword  =  $form_data['meta_keyword_'.$lang['locale']];
                        $translation->meta_desc =  $form_data['meta_desc_'.$lang['locale']];
                        $translation->page_desc =  $form_data['page_desc_'.$lang['locale']];

                        $translation->save();    
                    }  
                    else
                    {
                        /* Create New Language Entry  */
                        $translation     = $pages->getNewTranslation($lang['locale']);

                        $translation->static_page_id =  $id;
                        $translation->page_title   =  $form_data['page_title_'.$lang['locale']];
                        $translation->meta_keyword =  $form_data['meta_keyword_'.$lang['locale']];
                        $translation->meta_desc =  $form_data['meta_desc_'.$lang['locale']];
                        $translation->page_desc =  $form_data['page_desc_'.$lang['locale']];

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
        Flash::success($this->module_title.' Updated Successfully');
      
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