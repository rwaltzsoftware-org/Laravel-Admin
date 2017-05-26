<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactEnquiryModel;

use App\Common\Traits\MultiActionTrait;

use Session;
use Validator;
use Flash;

class ContactEnquiryController extends Controller
{
    use MultiActionTrait;

	public function __construct(ContactEnquiryModel $contact_enquiry) 
	{
        $this->arr_view_data 		= [];
		$this->ContactEnquiryModel 	= $contact_enquiry;

        $this->BaseModel            = $this->ContactEnquiryModel;

		$this->module_url_path 		= url(config('app.project.admin_panel_slug')."/contact_enquiry");
        $this->module_view_folder   = "admin.contact_enquiry";
        $this->module_title         = "Contact Enquiry";
	}

	public function index() 
	{	
		$arr_contact_enquiry = array();
		$obj_contact_enquiry = $this->BaseModel->get();
		
		if($obj_contact_enquiry != FALSE)
		{
			$arr_contact_enquiry = $obj_contact_enquiry->toArray();
		}

		$this->arr_view_data['arr_contact_enquiry'] = $arr_contact_enquiry;
        $this->arr_view_data['page_title'] 			= "Manage ".str_singular($this->module_title);
        $this->arr_view_data['module_title'] 		= str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] 	= $this->module_url_path;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
	}

	public function view($enc_id)
	{
		$id = base64_decode($enc_id);

        $view_enquiry = $this->BaseModel->where('id',$id)->update(['is_view'=>'1']);  

		$arr_contact_enquiry_details = array();
		$obj_contact_enquiry 		 = $this->BaseModel->where('id','=',$id)->first();
		if($obj_contact_enquiry != FALSE)
		{
			$arr_contact_enquiry_details = $obj_contact_enquiry->toArray();
		}

		$this->arr_view_data['arr_contact_enquiry'] = $arr_contact_enquiry_details;
        $this->arr_view_data['page_title'] 			= "View ".str_singular($this->module_title);
        $this->arr_view_data['module_title'] 		= str_plural($this->module_title);
        $this->arr_view_data['module_url_path'] 	= $this->module_url_path;

        return view($this->module_view_folder.'.view',$this->arr_view_data);
	}

	

}
