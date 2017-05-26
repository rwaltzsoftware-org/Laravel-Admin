<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;

use Validator;
use Flash;
use Sentinel;
use Hash;
 
class AccountSettingsController extends Controller
{

    public function __construct(
                                
                                UserModel $user,
                                ActivityLogsModel $activity_logs
                               )
    {
        $this->UserModel          = $user;
        $this->BaseModel          = $this->UserModel;
        $this->ActivityLogsModel  = $activity_logs;
        
        $this->arr_view_data      = [];
        $this->admin_url_path     = url(config('app.project.admin_panel_slug'));
        $this->module_url_path    = $this->admin_url_path."/account_settings";

        $this->module_title       = "Account Settings";
        $this->module_view_folder = "admin.account_settings";
        
        $this->theme_color        = theme_color();

        $this->module_icon        = "fa-cogs";
    }


    public function index()
    {
        $arr_account_settings = array();

        $arr_data  = [];
        
        $obj_data  = Sentinel::getUser();
        
        if($obj_data)
        {
           $arr_data = $obj_data->toArray();    
        }

        if(isset($arr_data) && sizeof($arr_data)<=0)
        {
            return redirect($this->admin_url_path.'/login');
        }

        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['page_title']      = str_plural($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['theme_color']     = $this->theme_color;
        $this->arr_view_data['module_icon']     = $this->module_icon;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
 

    public function update(Request $request)
    {
        $arr_rules = array();
        
        $obj_data  = Sentinel::getUser();
        $first_name = $obj_data->first_name;
        $last_name  = $obj_data->last_name;

        $arr_rules['first_name']            = "required";
        $arr_rules['last_name']             = "required"; 
        $arr_rules['email']                 = "email|required";
        $arr_rules['old_password']          = "sometimes";
        $arr_rules['new_password']          = "sometimes";
       
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {       
            return redirect()->back()->withErrors($validator)->withInput();  
        }
  
        
        if($this->UserModel->where('email',$request->input('email'))
                           ->where('id','!=',$obj_data->id)
                           ->count()==1)
        {
            Flash::error('This Email id already present in our system, please try another one');
            return redirect()->back();
        }
        
        if($request->has('old_password'))
        {
            $old_password= $request->input('old_password');

            if(Hash::check($old_password,$obj_data->password))
            {
                $new_password = $request->input('new_password');

                $update_password = Sentinel::update($obj_data,['password'=>$new_password]);
            }
            else
            {
                Flash::error('Incorrect Old Password');
                return redirect()->back();
            }
        }
        
        $arr_data['first_name']   = $request->input('first_name');
        $arr_data['last_name']    = $request->input('last_name');
        $arr_data['email']        = $request->input('email');

        $obj_data = Sentinel::update($obj_data, $arr_data);

        if($obj_data)
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
            Flash::error('Problem Occurred, While Updating '.str_singular($this->module_title));  
        } 
      
        return redirect()->back();
    }
}
