<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\KeywordTranslationModel;
use App\Models\LanguageModel;

use App\Common\Services\LanguageService;

use Validator;
use Flash;
use Sentinel;
use Session;
use DB;
use Datatables;
use Cache;

class KeywordTranslationController extends Controller
{
    
    public function __construct(KeywordTranslationModel $translation,
                                LanguageService $langauge_service,
                                LanguageModel $langauge
                                )
    {

        $this->KeywordTranslationModel      = $translation;        
        $this->BaseModel                    = $this->KeywordTranslationModel;
        $this->LanguageModel                = $langauge;
        $this->LanguageService              = $langauge_service;    

        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/keyword_translation");

        $this->module_title                 = "Keyword Translation";
        $this->module_view_folder           = "admin.keyword_translation";
        $this->theme_color                  = theme_color(); 
        $this->module_icon          		= "fa-language";
        $this->create_icon          		= "fa-plus-square-o";
        $this->edit_icon            		= "fa-edit";  
        $this->view_icon            		= "fa-eye"; 
    }

    public function index()
    {
        $this->arr_view_data['page_title']      = "Manage ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['theme_color']     = $this->theme_color;
        $this->arr_view_data['module_icon']     = $this->module_icon;
        
        $this->arr_view_data['arr_lang']              = $this->LanguageService->get_all_language();

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
    public function get_records(Request $request)
    {
        $obj_keyword = $this->get_keyword_records($request);

        $current_context = $this;

        $json_result  = Datatables::of($obj_keyword);
        
        $json_result = $json_result->blacklist(['id']);                    

        /* Modifying Columns */
        $json_result =  $json_result
                                    
                                    ->editColumn('built_edit_href',function($data) use ($current_context)
                                    {
                                        return  $current_context->module_url_path.'/edit/'.base64_encode($data->keyword_id);
                                    })->make(true);

        $build_result = $json_result->getData();


        return response()->json($build_result);        
    }

    function get_keyword_records(Request $request)
    {
        $locale = '';
        if(Session::has('locale'))
        {
            $locale = Session::get('locale');
        }
        else
        {
            $locale = 'en';
        }
        
        /* Prefixed table name are required wherever we are using DB::raw calls */                        
        
        $keyword_table = $this->BaseModel->getTable();   
        $prefixed_keyword_table = DB::getTablePrefix().$this->BaseModel->getTable();
        
        $language_table = $this->LanguageModel->getTable();   
        $prefixed_language_table = DB::getTablePrefix().$this->LanguageModel->getTable();

        $obj_keyword = DB::table($keyword_table)
                                        ->select(DB::raw( $prefixed_keyword_table.".id as keyword_id,".
                                                          $prefixed_keyword_table.".keyword as keyword,".
                                                          $prefixed_keyword_table.".title as title,".
                                                          $prefixed_keyword_table.".locale as locale"
                                                        ))
                                        ->leftJoin($prefixed_language_table,$prefixed_language_table.".locale",' = ',$prefixed_keyword_table.'.locale');

        $arr_search_column = $request->input('column_filter');

        if(isset($arr_search_column['q_keyword']) && $arr_search_column['q_keyword']!="")
        {
            $search_term = $arr_search_column['q_keyword'];
            $obj_keyword = $obj_keyword->where($keyword_table.'.keyword','LIKE', '%'.$search_term.'%');   
        }

        if(isset($arr_search_column['q_title']) && $arr_search_column['q_title']!="")
        {
            $search_term = $arr_search_column['q_title'];
            
            $obj_keyword = $obj_keyword->where($keyword_table.'.title','LIKE', '%'.$search_term.'%');
        }
        
        if(isset($arr_search_column['q_locale']) && $arr_search_column['q_locale']!="")
        {
            $search_term = $arr_search_column['q_locale'];
            
            $obj_keyword = $obj_keyword->where($language_table.'.locale','LIKE', '%'.$search_term.'%');
        }
        
        return $obj_keyword ;
    }
    public function create()
    {
    	
        $this->arr_view_data['arr_lang']              = $this->LanguageService->get_all_language();
        $this->arr_view_data['page_title']            = "Create ".str_singular($this->module_title);
        $this->arr_view_data['module_title']          = $this->module_title;
        $this->arr_view_data['module_url_path']       = $this->module_url_path;
        $this->arr_view_data['theme_color']           = $this->theme_color;
        $this->arr_view_data['module_icon']           = $this->module_icon;
        $this->arr_view_data['create_icon']           = $this->create_icon;   

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        
    	$arr_rules = $arr_insert = $arr_tmp = $arr_build = [];
        
        $arr_lang = $this->LanguageService->get_all_language();

        foreach ($arr_lang as $key => $value) 
        {
            $title_name = str_slug($value['title'],"_");
            
            if($value['locale'] == 'en')
            {
                $arr_insert['english']    = $request->input('english');

            } 

            $arr_insert[$title_name]    = $request->input($title_name);
            
        }
    	
        $arr_rules['english']     = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {       
            return redirect()->back()->withErrors($validator)->withInput();  
        }

        
        if(isset($arr_insert) && sizeof($arr_insert) > 0 )
        {           
            $status = '';

            if(isset($arr_insert['english']) && sizeof($arr_insert['english']) > 0)
            {
                foreach ($arr_insert['english'] as $inr_key => $data) 
                {
                    $keyword    = str_slug($data, "_");

                    $arr_tmp[$inr_key] =  $keyword;       
                }
            }

            /*-----------------------------------------------------------------------
            |Flush existing translation cache
            -----------------------------------------------------------------------*/

                Cache::forget('translation_data');

            /*---------------------------------------------------------------------*/
            
            foreach ($arr_lang as $key =>$lang) 
            {
                $title = strtolower($lang['title']);

                if(isset($arr_insert[$title]) && sizeof($arr_insert[$title]) > 0 && isset($arr_tmp) && sizeof($arr_tmp) > 0)
                {
                    foreach ($arr_insert[$title] as $inr_key => $value) 
                    {   
                        $arr_build   = array('title' =>$value,'locale' =>$lang['locale'],'keyword'=>$arr_tmp[$inr_key] );
                        
                        if($this->KeywordTranslationModel->where([
                                                                  'keyword' => $arr_build['keyword'],
                                                                  'locale'  => $arr_build['locale']
                                                                ])
                                                         ->get()->count() > 0)
                        {
                            $status = $this->KeywordTranslationModel->where([
                                                                    'keyword' => $arr_build['keyword'],
                                                                    'locale'  => $arr_build['locale']
                                                                          ])
                                                                    ->update($arr_build);
                        }
                        else
                        {
                            $status = $this->KeywordTranslationModel->insert($arr_build);
                        }                        
                    } 
                }                   
            }
            
            if($status)
            {
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
            else
            {
                Flash::error('Problem Occured, While Creating '.str_singular($this->module_title));
            }
            
        }       
	    else
	    {
	    	 Flash::error('Problem Occured, While Creating '.str_singular($this->module_title));
	    }

	    return redirect()->back();
    }
    
    public function edit($enc_id = false)
    {
        if($enc_id == false)
        {
            return redirect()->back();
        }
        
        $arr_data = $arr_final_data = [];
        
        $keyword  = '';

        $id = base64_decode($enc_id);

        $obj_data = $this->BaseModel->where('id',$id)->first();

        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
            $keyword  = $arr_data['keyword'];
            $arr_final_data = $this->BaseModel->where('keyword',$arr_data['keyword'])->get()->toArray();
        }
        
        $this->arr_view_data['page_title']      = "Edit ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['theme_color']     = $this->theme_color;
        $this->arr_view_data['module_icon']     = $this->module_icon;
        $this->arr_view_data['edit_icon']       = $this->edit_icon;
        
        $this->arr_view_data['arr_data']        = $arr_final_data;
        $this->arr_view_data['keyword']         = $keyword;

        return view($this->module_view_folder.'.edit',$this->arr_view_data);
    }

    public function update(Request $request)
    {
        


        $arr_rules =  $keyword_arr = $update_arr = [];        
        
        $arr_rules['keyword']      = "required";
        $arr_rules['keyword_arr']  = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {       
            return redirect()->back()->withErrors($validator)->withInput();  
        }
        
        $keyword_arr = $request->input('keyword_arr');
        
        $keyword     = $request->input('keyword');
        
        if(isset($keyword_arr) && $keyword_arr != '' )
        {     

            /*-----------------------------------------------------------------------
            |Flush existing translation cache
            -----------------------------------------------------------------------*/

                Cache::forget('translation_data');

            /*---------------------------------------------------------------------*/

            foreach ($keyword_arr as $key => $value) 
            {
                    
                $update = $this->KeywordTranslationModel->where('id',$value['id'])
                                                            ->update(array('title'=>$value['title']));
            }

            if($update)
            {
                /*-------------------------------------------------------
                |   Activity log Event
                --------------------------------------------------------*/
                    $arr_event                 = [];
                    $arr_event['ACTION']       = 'EDIT';
                    $arr_event['MODULE_TITLE'] = $this->module_title;

                    $this->save_activity($arr_event);

                /*----------------------------------------------------------------------*/
                Flash::success(str_singular($this->module_title).' Updated Successfully');
            }
            else
            {
                Flash::error('Problem Occured, While Updating '.str_singular($this->module_title));
            }            
        }       
        else
        {
             Flash::error('Problem Occured, While Updating '.str_singular($this->module_title));
        }

        return redirect()->back();
    }
}
