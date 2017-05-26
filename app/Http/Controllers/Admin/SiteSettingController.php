<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SiteSettingModel;
use App\Events\ActivityLogEvent;
use App\Models\ActivityLogsModel;

use Validator;
use Flash;
use Input;
use Sentinel;
 
class SiteSettingController extends Controller
{
    
    public function __construct(SiteSettingModel $siteSetting,
                                ActivityLogsModel $activity_logs)
    {
        $this->SiteSettingModel   = $siteSetting;
        $this->arr_view_data      = [];
        $this->BaseModel          = $this->SiteSettingModel;
        $this->ActivityLogsModel  = $activity_logs;

        /*For activity log*/
        $this->obj_data           = Sentinel::getUser();
        $this->first_name         = $this->obj_data->first_name;
        $this->last_name          = $this->obj_data->last_name;
        
        $this->module_title       = "Site Settings";
        $this->module_view_folder = "admin.site_settings";
        $this->module_url_path    = url(config('app.project.admin_panel_slug')."/site_settings");
        $this->theme_color        = theme_color();
    }

    /*
    | Index  : Display Website settings page
    | auther : Paras Kale
    | Date   : 03/11/2016
    | @return \Illuminate\Http\Response
    */ 
 
    public function index()
    {
        $arr_data = array();   

        $obj_data =  $this->BaseModel->first();

        if($obj_data != FALSE)
        {
            $arr_data = $obj_data->toArray();    
        }

        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['page_title']      = str_singular($this->module_title);
        $this->arr_view_data['module_title']    = str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['theme_color']     = $this->theme_color;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
 

    /*
    | update() : Update the Website Settings
    | auther : Paras Kale
    | Date   : 03/11/2016
    | @param  int  $enc_id
    | @return \Illuminate\Http\Response
    */ 

    public function update(Request $request, $enc_id)
    {
        $id = base64_decode($enc_id);

        $arr_rules = array();

        $arr_data['site_name']            = "required";
        $arr_rules['site_email_address']  = "email|required";
        $arr_rules['site_contact_number'] = "required";  
        $arr_rules['site_address']        = "required";         
        $arr_rules['fb_url']              = "required";  
        $arr_rules['google_plus_url']     = "required"; 
        $arr_rules['twitter_url']         = "required";  
        $arr_rules['youtube_url']         = "required";
        $arr_rules['instagram_url']       = "required";  
        $arr_rules['site_status']         = "required";  

        
        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {       
            return back()->withErrors($validator)->withInput();  
        } 

        $arr_data['site_name']           = $request->input('site_name');
        $arr_data['site_address']        = $request->input('site_address');
        $arr_data['site_contact_number'] = $request->input('site_contact_number');
        $arr_data['meta_desc']           = $request->input('meta_desc');
        $arr_data['meta_keyword']        = $request->input('meta_keyword');
        $arr_data['site_email_address']  = $request->input('site_email_address');
        $arr_data['fb_url']              = $request->input('fb_url');
        $arr_data['google_plus_url']     = $request->input('google_plus_url');
        $arr_data['twitter_url']         = $request->input('twitter_url');
        $arr_data['youtube_url']         = $request->input('youtube_url');
        $arr_data['rss_feed_url']        = $request->input('rss_feed_url');
        $arr_data['instagram_url']       = $request->input('instagram_url');
        $arr_data['site_status']         = $request->input('site_status');

        $entity = $this->BaseModel->where('site_setting_id',$id)->update($arr_data);

        if($entity)
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
      
        return redirect()->back()->withInput();
    }
}
