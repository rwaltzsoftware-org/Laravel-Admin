<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Traits\MultiActionTrait;

use App\Models\UserModel;
use App\Models\CountryModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;
use Flash;
use Validator;
use Sentinel;

use DB;
use Datatables;

class UserController extends Controller
{
    use MultiActionTrait;

    public function __construct(UserModel $user,
                                CountryModel $country,
                                ActivityLogsModel $activity_logs)
    {
        $user = Sentinel::createModel();

        $this->UserModel                    = $user;
        $this->BaseModel                    = Sentinel::createModel();   // using sentinel for base model.
        $this->CountryModel                 = $country;
        $this->ActivityLogsModel            = $activity_logs;

        /*For activity log*/
        $this->obj_data                     = Sentinel::getUser();
        $this->first_name                   = $this->obj_data->first_name;
        $this->last_name                    = $this->obj_data->last_name;

        $this->user_profile_base_img_path   = public_path().config('app.project.img_path.user_profile_image');
        $this->user_profile_public_img_path = url('/').config('app.project.img_path.user_profile_image');

        $this->arr_view_data                = [];
        $this->module_url_path              = url(config('app.project.admin_panel_slug')."/users");
        $this->module_title                 = "Users";
        $this->modyle_url_slug              = "users";
        $this->module_view_folder           = "admin.users";
        $this->theme_color                  = theme_color();
    }	

    public function index()
    {
        $this->arr_view_data['arr_data'] = array();
        $obj_data = $this->BaseModel->whereHas('roles',function($query)
                                        {
                                            $query->where('slug','!=','admin');        
                                        })
        							//->with(['user'])
        							->get();

        if($obj_data)
        {
        	$arr_data = $obj_data->toArray();
        }	

        $this->arr_view_data['page_title']      = "Manage ".str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['theme_color']     = $this->theme_color;

        return view($this->module_view_folder.'.index', $this->arr_view_data);
    }


    function get_users_details(Request $request)
    {
        $user_details           = $this->BaseModel->getTable();
        $prefixed_user_details  = DB::getTablePrefix().$this->BaseModel->getTable();

        $obj_user = DB::table($user_details)
                                ->select(DB::raw($prefixed_user_details.".id as id,".
                                                 $prefixed_user_details.".email as email, ".
                                                 $prefixed_user_details.".is_active as is_active, ".
                                                 "CONCAT(".$prefixed_user_details.".first_name,' ',"
                                                          .$prefixed_user_details.".last_name) as user_name"
                                                 ))
                                ->whereNull($user_details.'.deleted_at')
                                ->orderBy($user_details.'.created_at','DESC');

        /* ---------------- Filtering Logic ----------------------------------*/                    
        $arr_search_column = $request->input('column_filter');
        
        if(isset($arr_search_column['q_name']) && $arr_search_column['q_name']!="")
        {
            $search_term      = $arr_search_column['q_name'];
            $obj_user = $obj_user->having('user_name','LIKE', '%'.$search_term.'%');
        }

        if(isset($arr_search_column['q_email']) && $arr_search_column['q_email']!="")
        {
            $search_term      = $arr_search_column['q_email'];
            $obj_user = $obj_user->where($user_details.'.email','LIKE', '%'.$search_term.'%');
        }

        return $obj_user;
    }

    public function get_records(Request $request)
    {
        $obj_user     = $this->get_users_details($request);

        $current_context = $this;

        $json_result     = Datatables::of($obj_user);

        $json_result     = $json_result->blacklist(['id']);
        
        $json_result     = $json_result->editColumn('enc_id',function($data) use ($current_context)
                            {
                                return base64_encode($data->id);
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

    public function create()
    {
        $obj_country = $this->CountryModel->where('is_active','=','1')->get(['id','country_code','country_name']);  
        if($obj_country)
        {
            $arr_country = $obj_country->toArray();                    
        }

        $this->arr_view_data['page_title']      = "Create ".str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['arr_country']     = $arr_country;
        $this->arr_view_data['theme_color']     = $this->theme_color;

        return view($this->module_view_folder.'.create', $this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules['password']       = "required";
        $arr_rules['first_name']     = "required";
        $arr_rules['last_name']      = "required";
        $arr_rules['email']          = "required";
        $arr_rules['country']        = "required";
        $arr_rules['street_address'] = "required";
        $arr_rules['phone']          = "required";
        $arr_rules['profile_image']  = "required|image";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        /* Check for email duplication */
        $does_exists = $this->BaseModel
                            ->where('email','=',$request->input('email'))
                            ->count();   
        if($does_exists)
        {
            Flash::error(str_singular($this->module_title).' Already Exists.');
            return redirect()->back()->withInput($request->all());
        }    

        /* User Proof upload */
        $file_name      = "default.jpg";
        $file_name      = $request->input('profile_image');
        $file_extension = strtolower($request->file('profile_image')->getClientOriginalExtension()); 
        $file_name      = sha1(uniqid().$file_name.uniqid()).'.'.$file_extension;
        $request->file('profile_image')->move($this->user_profile_base_img_path, $file_name);  

        $user = Sentinel::registerAndActivate([
            'first_name' => $request->input('first_name'),
            'email'      => $request->input('email'),
            'password'   => $request->input('password'),
        ]);

        if($user)
        {   
            /* Assign 'traveller' User Role */
            $user = Sentinel::findById($user->id);
            $role = Sentinel::findRoleBySlug('user');
            $user->roles()->attach($role);

            $arr_user_data                   = [];
            $arr_user_data['last_name']      = $request->input('last_name');
            $arr_user_data['profile_image']  = $file_name;
            $arr_user_data['country']        = $request->input('country');
            $arr_user_data['state']          = $request->input('state');
            $arr_user_data['city']           = $request->input('city');
            $arr_user_data['street_address'] = $request->input('street_address');
            $arr_user_data['zipcode']        = $request->input('zipcode');
            $arr_user_data['phone']          = $request->input('phone');
            $arr_user_data['is_active']      = '1';
            $user::where('id','=',$user->id)->update($arr_user_data);

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
            Flash::error('Problem Occured While Creating '.str_singular($this->module_title));
        }   
        
        return redirect()->back();
    }

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        
        $obj_user = $this->BaseModel->where('id','=',$id)
                                    ->first(['id','email','first_name','last_name','profile_image','country','state','city','street_address','zipcode','phone']);
        $arr_data = $arr_country = [];                                    
        
        if($obj_user)
        {
            $arr_data = $obj_user->toArray();
        }  

        $obj_country = $this->CountryModel->where('is_active','=','1')->get(['id','country_code','country_name']);  
        
        if($obj_country)
        {
            $arr_country = $obj_country->toArray();                    
        }                                     
        
        $this->arr_view_data['page_title']                   = "Edit ".str_singular($this->module_title);
        $this->arr_view_data['module_title']                 = str_plural($this->module_title);
        $this->arr_view_data['module_url_path']              = $this->module_url_path;
        $this->arr_view_data['arr_data']                     = $arr_data;
        $this->arr_view_data['arr_country']                  = $arr_country;
        $this->arr_view_data['user_profile_public_img_path'] = $this->user_profile_public_img_path;
        $this->arr_view_data['theme_color']                  = $this->theme_color;
        
        return view($this->module_view_folder.'.edit', $this->arr_view_data);
    }

    public function update(Request $request)
    {
        
        $arr_rules['user_id']            = "required";
        $arr_rules['first_name']         = "required";
        $arr_rules['last_name']          = "required";  
        $arr_rules['country']            = "required"; 
        $arr_rules['street_address']     = "required";
        //$arr_rules['state']              = "required"; 
        //$arr_rules['city']               = "required";
        $arr_rules['phone']            = "required";
        $arr_rules['profile_image']        = "image"; 

        $message                        = [];
        $message['profile_image.image'] = 'Please select valid image';
        
        $validator = Validator::make($request->all(),$arr_rules,$message);

        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        /* Image Upload starts here */
        $is_new_file_uploaded = FALSE;

         if ($request->hasFile('profile_image')) 
         {
            $image_validation = Validator::make(array('file'=>$request->file('profile_image')),
                                                array('file'=>'mimes:jpg,jpeg,png'));
            

            
            if($request->file('profile_image')->isValid() && $image_validation->passes())
            {

            }
            else
            {
                Flash::error('Not valid image! Please Select Proper Image Format');
                return redirect()->back();
            }

            $arr_image_size = [];
            $arr_image_size = getimagesize($request->file('profile_image'));

            if(isset($arr_image_size) && $arr_image_size==false)
            {
                Flash::error('Please use valid image');
                return redirect()->back(); 
            }

            /*-----------------------------------------------------------------
                $arr_image_size[0] = width of image
                $arr_image_size[1] = height of image
            -------------------------------------------------------------------*/

            /* Check Resolution */
            $maxHeight = 140;
            $maxWidth  = 140;

            if(($arr_image_size[0] < $maxWidth) && ($arr_image_size[1] < $maxHeight))
            {
                Flash::error('Image resolution should not be less than 140 x 140 pixel and related dimensions');
                return redirect()->back();
            }  

            $excel_file_name = $request->input('profile_image');
            $fileExtension   = strtolower($request->file('profile_image')->getClientOriginalExtension()); 
            $file_name       = sha1(uniqid().$excel_file_name.uniqid()).'.'.$fileExtension;
            $request->file('profile_image')->move($this->user_profile_base_img_path,$file_name); 
            
            /* Unlink the Existing file from the folder */
            $obj_image = $this->BaseModel->where('id',$request->input('user_id'))->first(['profile_image']);
            if($obj_image)   
            {   
                $_arr = [];
                $_arr = $obj_image->toArray();
                if(isset($_arr['profile_image']) && $_arr['profile_image'] != "" )
                {
                    $unlink_path    = $this->user_profile_base_img_path.$_arr['profile_image'];
                    @unlink($unlink_path);
                }
            }

            $is_new_file_uploaded = TRUE;         
        }
        $arr_user_data = [];

        if($is_new_file_uploaded)
        {
            $arr_user_data['profile_image'] = $file_name;
        }
               
        $arr_user_data['first_name']     = $request->input('first_name');
        $arr_user_data['last_name']      = $request->input('last_name');
        $arr_user_data['country']        = $request->input('country');
        $arr_user_data['state']          = $request->input('state');
        $arr_user_data['city']           = $request->input('city');
        $arr_user_data['street_address'] = $request->input('street_address');
        $arr_user_data['zipcode']        = $request->input('zipcode');
        $arr_user_data['phone']          = $request->input('phone');
            
        $obj_user = $this->BaseModel->where('id','=', $request->input('user_id'))->update($arr_user_data);

        if($obj_user)
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
            Flash::error('Problem Occured While Updating '.str_singular($this->module_title));
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
            Flash::error('Problem Occured While '.str_singular($this->module_title).' Activation ');
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
            Flash::error('Problem Occured While '.str_singular($this->module_title).' Deactivation ');
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
            Flash::error('Problem Occured While '.str_singular($this->module_title).' Deletion ');
        }

        return redirect()->back();
    }

     /*
    | multi_action() : mutiple actions like active/deactive/delete for multiple slected records
    | auther : Paras Kale 
    | Date : 01-02-2016    
    | @param  \Illuminate\Http\Request  $request
    */
    public function multi_action(Request $request)
    {
        $arr_rules = array();
        $arr_rules['multi_action'] = "required";
        $arr_rules['checked_record'] = "required";


        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Flash::error('Please Select '.str_plural($this->module_title) .' To Perform Multi Actions');  
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem Occured, While Doing Multi Action');
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

    public function perform_activate($id)
    {
        $entity = $this->BaseModel->where('id',$id)->first();
        

        if($entity)
        {
            return $this->BaseModel->where('id',$id)->update(['is_active'=>1]);
        }

        return FALSE;
    }

    public function perform_deactivate($id)
    {

        $entity = $this->BaseModel->where('id',$id)->first();
        
        if($entity)
        {
            return $this->BaseModel->where('id',$id)->update(['is_active'=>0]);
        }
        return FALSE;
    }

    public function perform_delete($id)
    {
        $entity = $this->BaseModel->where('id',$id)->first();
        if($entity)
        {

            /* Detaching Role from user Roles table */
            $user = Sentinel::findById($id);
            $role_owner     = Sentinel::findRoleBySlug('owner');
            $role_traveller = Sentinel::findRoleBySlug('traveller');
            $user->roles()->detach($role_owner);
            $user->roles()->detach($role_traveller);

           $delete_success = $this->BaseModel->where('id',$id)->delete();
            /*-------------------------------------------------------
            |   Activity log Event
            --------------------------------------------------------*/
                $arr_event                 = [];
                $arr_event['ACTION']       = 'REMOVED';
                $arr_event['MODULE_TITLE'] = $this->module_title;

                $this->save_activity($arr_event);
            /*----------------------------------------------------------------------*/
           return $delete_success;
        }

        return FALSE;
    }

    public function build_select_options_array(array $arr_data,$option_key,$option_value,array $arr_default)
    {

        $arr_options = [];
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

}
