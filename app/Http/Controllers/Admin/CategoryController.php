<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Traits\MultiActionTrait;

use App\Models\CategoryModel;  
use App\Models\CategoryTranslationModel;
use App\Common\Services\LanguageService; 
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use Validator;
use Session;
use Flash;
use File;
use Sentinel;
use DB;
use Datatables;

class CategoryController extends Controller
{
    use MultiActionTrait;
    
    public function __construct(
                                CategoryModel $category,
                                LanguageService $langauge,
                                CategoryTranslationModel $category_translation,
                                ActivityLogsModel $activity_logs
                                )
    {

        $this->category_base_img_path   = public_path().config('app.project.img_path.category');
        $this->category_public_img_path = url('/').config('app.project.img_path.category');

        $this->CategoryModel            = $category;
        $this->BaseModel                = $this->CategoryModel;
        $this->LanguageService          = $langauge;
        $this->CategoryTranslationModel = $category_translation;
        $this->ActivityLogsModel = $activity_logs;

        $this->arr_view_data      = [];
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/categories");
        $this->module_title       = "Category/Sub-Category";
        $this->module_url_slug    = "categories";
        $this->module_view_folder = "admin.category";
        /*For activity log*/
        $this->obj_data    = Sentinel::getUser();
        $this->first_name  = $this->obj_data->first_name;
        $this->last_name   = $this->obj_data->last_name;
        
        $this->theme_color        = theme_color();
    }   
 
    public function index()
    {
        $arr_lang     = array();
        $arr_category = array();

        $obj_data = $this->BaseModel->where('parent',0)->get();

        if($obj_data != FALSE)
        {
            $arr_category = $obj_data->toArray();
        }

        $this->arr_view_data['category_public_img_path'] = $this->category_public_img_path;
        $this->arr_view_data['arr_category']             = $arr_category;
        $this->arr_view_data['page_title']               = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']             = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['theme_color']              = $this->theme_color;
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }


    public function get_records(Request $request)
    {
        $obj_categories     = $this->get_categories($request);

        $current_context = $this;

        $json_result     = Datatables::of($obj_categories);

        $json_result     = $json_result->blacklist(['id']);
        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
                            })
                            ->editColumn('build_view_sub_category',function($data) use ($current_context)
                            {
                                $view_href =  $this->module_url_path.'/sub_categories/'.base64_encode($data->id);
                                $build_view_sub_category = '<a class="btn btn-success btn-sm show-tooltip call_loader" href="'.$view_href.'" title="View">View</a>';
                                return $build_view_sub_category;
                            })
                            ->editColumn('build_status_btn',function($data) use ($current_context)
                            {
                                if($data->is_active != null && $data->is_active == '0')
                                {   
                                    $build_status_btn = '<a class="btn btn-danger" title="Lock" btn-sm show-tooltip call_loader" href="'.$this->module_url_path.'/activate/'.base64_encode($data->id).'" onclick="return confirm(\'Are you sure to Activate this record?\')" ><i class="fa fa-lock"></i></a>';
                                }
                                elseif($data->is_active != null && $data->is_active == '1')
                                {
                                    $build_status_btn = '<a class="btn btn-success" title="Unlock" btn-sm show-tooltip call_loader" href="'.$this->module_url_path.'/deactivate/'.base64_encode($data->id).'" onclick="return confirm(\'Are you sure to Deactivate this record?\')" ><i class="fa fa-unlock"></i></a>';
                                }
                                return $build_status_btn;
                            })    
                            ->editColumn('build_action_btn',function($data) use ($current_context)
                            {   
                                $edit_href =  $this->module_url_path.'/edit/'.base64_encode($data->id);
                                $build_edit_action = '<a class="btn btn-primary btn-sm show-tooltip call_loader" href="'.$edit_href.'" title="Edit"><i class="fa fa-edit" ></i></a>';

                                $delete_href =  $this->module_url_path.'/delete/'.base64_encode($data->id);
                                $confirm_delete = 'onclick="return confirm(\'Are you sure to delete this record?\')"';
                                $build_delete_action = '<a class="btn btn-danger btn-sm show-tooltip call_loader" '.$confirm_delete.' href="'.$delete_href.'" title="Delete"><i class="fa fa-trash" ></i></a>';

                                return $build_action = $build_edit_action.' '.$build_delete_action;
                            })
                            ->make(true);

        $build_result = $json_result->getData();
        
        return response()->json($build_result);
    }

    public function get_locale()
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
        return $locale;
    }

    function get_categories(Request $request)
    {
        $locale = $this->get_locale();

        $categories_table           = $this->BaseModel->getTable();
        $prefixed_categories_table  = DB::getTablePrefix().$this->BaseModel->getTable();

        $categories_trans_table     = $this->CategoryTranslationModel->getTable();
        $prefixed_categories_trans_table  = DB::getTablePrefix().$this->CategoryTranslationModel->getTable();

        $obj_categories = DB::table($categories_table)
                                ->select(DB::raw($prefixed_categories_table.".id as id,".
                                                 $prefixed_categories_table.".parent as parent,".
                                                 $prefixed_categories_table.".is_active as is_active,".
                                                 $prefixed_categories_trans_table.".category_title as category_title,".
                                                 $prefixed_categories_trans_table.".category_slug as category_slug,".
                                                 $prefixed_categories_trans_table.".locale as locale"
                                                 ))
                                ->where($categories_table.'.parent','=',0)
                                ->whereNull($categories_table.'.deleted_at')
                                ->whereNull($prefixed_categories_trans_table.'.deleted_at')
                                ->orderBy($categories_table.'.created_at','DESC')
                                ->where($categories_trans_table.'.locale', '=', $locale)
                                ->join($categories_trans_table,$categories_table.'.id' ,'=', $categories_trans_table.'.category_id');

        /* ---------------- Filtering Logic ----------------------------------*/                    

        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_category']) && $arr_search_column['q_category']!="")
        {
            $search_term      = $arr_search_column['q_category'];
            $obj_categories = $obj_categories->where($categories_trans_table.'.category_title','LIKE', '%'.$search_term.'%');
        }

        return $obj_categories;
    }


    public function index_sub_category($enc_id)
    {
        $parent_id = base64_decode($enc_id); 

        $arr_lang = array();
        $arr_category = array();

        /* Get Parent Category Info */
        $parent_category = $this->BaseModel->where('id',$parent_id)->first();

        if($parent_category)
        {
           $page_title = "Manage Sub-".str_singular($this->module_title)." for ".$parent_category->category_title;       
        }

        $res = $this->BaseModel->where('parent',$parent_id)->get();
        if($res != FALSE)
        {
            $arr_category = $res->toArray();
        }

        $category_public_img_path = $this->category_public_img_path;

        $this->arr_view_data['category_public_img_path'] = $this->category_public_img_path;
        $this->arr_view_data['arr_category']             = $arr_category;
        $this->arr_view_data['parent_id']                = $parent_id;
        $this->arr_view_data['page_title']               = "Manage Sub-".str_plural($this->module_title);
        $this->arr_view_data['module_title']             = "Sub-".str_plural($this->module_title);
        $this->arr_view_data['module_url_path']          = $this->module_url_path;
        $this->arr_view_data['theme_color']        = $this->theme_color;
        return view($this->module_view_folder.'.index_sub_category',$this->arr_view_data);
    }    


    public function create($enc_parent_id=FALSE)
    {

        $parent_id = isset($enc_parent_id)?base64_decode($enc_parent_id):0;

        $arr_parent_category = $this->get_all_parent_category();


        $this->arr_view_data['arr_parent_category_options'] = $this->build_select_options_array($arr_parent_category,
                                'id',
                                        'category_title',
                                        ['0'=>'Main Category']    
                                        );


        $this->arr_view_data['parent_id']    = $parent_id;
        $this->arr_view_data['arr_lang']     = $this->LanguageService->get_all_language();
        $this->arr_view_data['page_title']   = "Create ".str_singular($this->module_title);
        $this->arr_view_data['module_title'] = str_singular($this->module_title);
        $this->arr_view_data['theme_color']        = $this->theme_color;
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }


    /*
    | store() : Stores newly created coutry.
    | auther : Paras Kale 
    | Date : 02-02-2016
    | @param  \Illuminate\Http\Request  $request
    | @return \Illuminate\Http\Response
    */

    public function store(Request $request)
    {  
        $form_data = array();

        /* English Required */
        $arr_rules['title_en'] = "required";
        $arr_rules['parent']   = "required";
        $arr_rules['image']    = "required|image|mimes:jpg,jpeg,png";
        
         
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Flash::error('All Fields Required');
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    
        /* File uploading code starts here */

        $form_data = $request->all();

        $file_name = "default.jpg";
        
        $file_name = $request->input('image');
        $file_extension = strtolower($request->file('image')->getClientOriginalExtension()); 

        $file_name = sha1(uniqid().$file_name.uniqid()).'.'.$file_extension;
        $request->file('image')->move($this->category_base_img_path, $file_name);  

        /* Check if category already exists with given translation */
        $does_exists = $this->BaseModel
                            ->where('parent',$request->input('parent'))
                            ->whereHas('translations',function($query) use($request)
                                    {
                                        $query->where('locale','en')
                                              ->where('category_title',$request->input('title_en'));      
                                    })
                            ->count()>0;   


                            
        if($does_exists)
        {
            Flash::error(str_singular($this->module_title).' Already Exists.');
            return redirect()->back();
        }


        /* Insert into Category Table */

        $arr_data               = array();
        $arr_data['image']      = $file_name;
        $arr_data['parent']     = $request->input('parent');

        $category = $this->BaseModel->create($arr_data);

        if($category)      
        {
            $arr_lang =  $this->LanguageService->get_all_language();      
       
            /* insert record into translation table */
            if(sizeof($arr_lang) > 0 )
            {
                foreach ($arr_lang as $lang) 
                {            
                    $arr_data = array();
                    $title = 'title_'.$lang['locale'];

                    if( isset($form_data[$title]) && $form_data[$title] != '')
                    { 
                        $translation                 = $category->translateOrNew($lang['locale']);
                        $translation->category_id    = $category->id;
                        $translation->category_title = $form_data[$title];
                        $translation->category_slug  = str_slug($form_data[$title], "-");
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
                Flash::error('Problem Occurred, While Creating '.str_singular($this->module_title));
            }
        }

        return redirect()->back();
    }

    public function edit($enc_id)
    {

        $id = base64_decode($enc_id);

        $data     = array();
        $arr_lang = $this->LanguageService->get_all_language();

        $category_image  = "default.jpg";
        $category_parent = "0";

        $obj_data = $this->BaseModel->where('id', $id)->with(['translations'])->first();

        $arr_category = [];
        if($obj_data)
        {
           $arr_category = $obj_data->toArray(); 

           /* Arrange Locale Wise */
           $arr_category['translations'] = $this->arrange_locale_wise($arr_category['translations']);
        }


        $category_public_img_path = $this->category_public_img_path;

        $this->arr_view_data['edit_mode']                = TRUE;
        $this->arr_view_data['enc_id']                   = $enc_id;
        $this->arr_view_data['arr_lang']                 = $this->LanguageService->get_all_language();
        $this->arr_view_data['category_public_img_path'] = $category_public_img_path;
        $this->arr_view_data['theme_color']              = $this->theme_color;
        $arr_parent_category                             = $this->get_all_parent_category();

        $this->arr_view_data['arr_parent_category_options'] = $this->build_select_options_array($arr_parent_category,
                            'id',
                            'category_title',
                            ['0'=>'Main Category']    
                            );
        $this->arr_view_data['arr_category'] = $arr_category;  

        $this->arr_view_data['page_title']   = "Edit ".str_singular($this->module_title);
        $this->arr_view_data['module_title'] = str_singular($this->module_title);

        return view($this->module_view_folder.'.edit',$this->arr_view_data);   
    }


    public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);

        $arr_rules             = array();
        $arr_rules['title_en'] = "required";

        if($request->has('parent'))
        {
            $arr_rules['parent']   = "required";
        }

        $arr_rules['image']    = "image";
        
         
        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $form_data = array();
        $form_data = $request->all();   

        /* Get All Active Languages */ 
  
        $arr_lang = $this->LanguageService->get_all_language();  

        /* Retrieve Existing Category*/
        $category = $this->BaseModel->where('id',$id)->first();

        if(!$category)
        {
            Flash::error('Problem Occurred While Retrieving '.str_singular($this->module_title));
            return redirect()->back();   
        }

        /* Check if category already exists with given translation */
        $does_exists = $this->BaseModel->where('parent',$category->parent)
                            ->where('id','<>',$id)
                            ->whereHas('translations',function($query) use($request)
                                        {
                                            $query->where('locale','en')
                                                  ->where('category_title',$request->input('title_en'));      
                                        })
                            ->count()>0;   
        if($does_exists)
        {
            Flash::error(str_singular($this->module_title).' Already Exists');
            return redirect()->back();
        }


        /*  File uploading code starts here  */

         $is_new_file_uploaded = FALSE;

         if ($request->hasFile('image')) 
         {
            $excel_file_name = $request->input('image');
            $fileExtension   = strtolower($request->file('image')->getClientOriginalExtension());

            $this->perform_category_image_unlink($category);

            $file_name = sha1(uniqid().$excel_file_name.uniqid()).'.'.$fileExtension;
            $request->file('image')->move($this->category_base_img_path, $file_name);    

            $is_new_file_uploaded = TRUE;         
        }
        
        $category_instance = clone $category ;
        
        /* Update Parent Category */   
        $arr_data = [];  

        if($request->has('parent'))
        {
            $arr_data['parent'] = $request->input('parent');
        }   

        if($is_new_file_uploaded)
        {
            $arr_data['image'] = $file_name;
        }

        $category_instance->update($arr_data);

        /* Insert Multi Lang Fields */

        if(sizeof($arr_lang) > 0)
        { 
            foreach($arr_lang as $i => $lang)
            {
                $translate_data_ary = array();
                $title = 'title_'.$lang['locale'];

                if(isset($form_data[$title]) && $form_data[$title]!="")
                {
                    /* Get Existing Language Entry */
                    $translation = $category->getTranslation($lang['locale']);    
                    if($translation)
                    {
                        $translation->category_title = $form_data['title_'.$lang['locale']];
                        $translation->category_slug  = str_slug($form_data['title_'.$lang['locale']], "-");
                        $translation->save();    
                    }  
                    else
                    {
                        /* Create New Language Entry  */
                        $translation                 = $category->getNewTranslation($lang['locale']);
                        $translation->category_id    = $id;
                        $translation->category_title = $form_data['title_'.$lang['locale']];
                        $translation->category_slug  = str_slug($form_data['title_'.$lang['locale']], "-");
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

    public function multi_action(Request $request)
    {
        $arr_rules                   = array();
        $arr_rules['multi_action']   = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Flash::error('Please Select '.str_plural($this->module_title) .' To Perform Multi Actions');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action   = $request->input('multi_action');
        $checked_record = $request->input('checked_record');


        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Flash::error('Problem Occurred, While Doing Multi Action');
            return redirect()->back();
        }

        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete")
            {
               $this->perform_delete(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' Deleted Successfully'); 
            } 
            elseif($multi_action=="activate")
            {
               $this->perform_activate(base64_decode($record_id)); 
               Flash::success(str_plural($this->module_title).' Activated Successfully'); 
            }
            elseif($multi_action=="deactivate")
            {
               $this->perform_deactivate(base64_decode($record_id));    
               Flash::success(str_plural($this->module_title).' Blocked Successfully');  
            }
        }

        return redirect()->back();
    }
    
    public function activate($enc_id = FALSE)
    {
        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_activate(base64_decode($enc_id)))
        {
            Flash::success(str_singular($this->module_title).' Activated Successfully');
        }
        else
        {
            Flash::error('Problem Occurred While Activating '.str_singular($this->module_title));
        }

        return redirect()->back();
    }

    public function deactivate($enc_id = FALSE)
    {
        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_deactivate(base64_decode($enc_id)))
        {
            Flash::success(str_singular($this->module_title).' Deactivated Successfully');
        }
        else
        {
            Flash::error('Problem Occurred While Deactivating '.str_singular($this->module_title));
        }

        return redirect()->back();
    }

    public function delete($enc_id = FALSE)
    {
     
        if(!$enc_id)
        {
            return redirect()->back();
        }
            
        if($this->perform_delete(base64_decode($enc_id)))
        {
            Flash::success(str_singular($this->module_title).' Deleted Successfully');
        }
        else
        {
            Flash::error('Problem Occurred While Deleting '.str_singular($this->module_title));
        }

        return redirect()->back();
    }


    public function perform_activate($id)
    {
        $category     = $this->BaseModel->where('id',$id)->update(['is_active'=>1]);
        /*$sub_category = $this->BaseModel->where('parent',$id)->update(['is_active'=>1]);*/

        if($category)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function perform_deactivate($id)
    {
        $category     = $this->BaseModel->where('id',$id)->update(['is_active'=>0]);
        $sub_category = $this->BaseModel->where('parent',$id)->update(['is_active'=>0]);
        
        if($category && $sub_category)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function perform_delete($id)
    {
        $category = $this->BaseModel->where('id',$id)    
                                    ->first();

        if($category)
        {
            if($category->parent == 0)
            {
                $category = $category->load(['child_category']);

                $is_delete = $this->perform_category_image_unlink($category);
            }
            else
            {
                $category = $category->load(['parent_category']);

                $is_delete = $this->perform_category_image_unlink($category);
            }
            
            if($is_delete == true)
            {

                $this->CategoryTranslationModel->where('category_id',$category->id)
                                               ->delete();

                return $category->delete();
            }
        }

        return FALSE;
    }
   
    public function perform_category_image_unlink($category)
    {   
        if($category)
        {
            if($category->parent_category)
            {
                if($category->image)
                {
                    if(File::exists($this->category_base_img_path.$category->image))
                    {
                        unlink($this->category_base_img_path.$category->image);
                    }

                    return true;
                }
            }
            else if($category->child_category)
            {
                if($category->child_category)
                {
                   foreach($category->child_category as $key => $data)
                   {
                        if($data->image)
                        {
                            if(File::exists($this->category_base_img_path.$data->image))
                            {
                                unlink($this->category_base_img_path.$data->image);
                            }

                        }

                        $this->CategoryTranslationModel->where('category_id',$data->id)
                                                       ->delete();
                        $data->delete();
                   } 

                }

                if($category->image)
                {
                    if(File::exists($this->category_base_img_path.$category->image))
                    {
                        unlink($this->category_base_img_path.$category->image);
                    }

                    return true;
                }
            }
        }
        else
        {
            return false;
        }

    }

  
    public function build_select_options_array(array $arr_data,$option_key,$option_value,array $arr_default)
    {

        $arr_options = [];
        /*--------------------------------------------------------------
        |   Array Default - Main Category Hide For Temporary
        ---------------------------------------------------------------*/

        if(sizeof($arr_default)>0)
        {
            $arr_options =  $arr_default;   
        }

        if(sizeof($arr_data)>0)
        {
            foreach ($arr_data as $key => $data) 
            {
                if(isset($data[$option_key]) && isset($data[$option_value]))
                {
                    $arr_options[$data[$option_key]] = $data[$option_value];
                }
            }
        }

        return $arr_options;

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

    /**
     * Fetch all parent category list 
     * 
     * @author: Paras Kale
     * @date   09-02-2016
     * @return array
     * 
     */
    public function  get_all_parent_category()
    {
        $arr_parent_category = array();
        $obj_data = $this->BaseModel->where('parent','0')->get();

        if($obj_data)
        {
           $arr_parent_category = $obj_data->toArray();

        }

        return $arr_parent_category;
    }

}
