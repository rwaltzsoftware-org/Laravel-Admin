<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\UserModel;

class DashboardController extends Controller
{
	public function __construct(UserModel $user)
	{
		$this->arr_view_data      = [];
		$this->module_title       = "Dashboard";
		$this->UserModel          = $user;
		$this->module_view_folder = "admin.dashboard";
		$this->admin_url_path     = url(config('app.project.admin_panel_slug'));
	}
   
    public function index()
    {
    	$arr_tile_color = array('tile-red','tile-green','tile-magenta','');

    	$this->arr_view_data['page_title']     = $this->module_title;
    	$this->arr_view_data['admin_url_path'] = $this->admin_url_path;
    	$this->arr_view_data['arr_tile_color'] = $arr_tile_color;
    	$this->arr_view_data['arr_final_tile'] = $this->built_dashboard_tiles();

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function built_dashboard_tiles()
    {
    	/*------------------------------------------------------------------------------
    	| Note: Directly Use icon name - like, fa fa-user and use directly - 'user'
    	------------------------------------------------------------------------------*/
					
		$arr_final_tile[] = ['module_slug'  => 'account_settings',
							  'css_class'   => 'cogs',
							  'module_title'=> 'Account Settings'];
		
		$arr_final_tile[] = ['module_slug'  => 'admin_users',
							  'css_class'   => 'user-secret',
							  'module_title'=> 'Admin Users'];	

		$arr_final_tile[] = ['module_slug'  => 'contact_enquiry',
							  'css_class'   => 'info-circle',
							  'module_title'=> 'Contact Enquirys'];	

		$arr_final_tile[] = ['module_slug'  => 'static_pages',
							  'css_class'   => 'sitemap',
							  'module_title'=> 'CMS'];

		$arr_final_tile[] = ['module_slug'  => 'email_template',
							  'css_class'   => 'envelope',
							  'module_title'=> 'Email Templates'];

		$arr_final_tile[] = ['module_slug'  => 'faq',
							  'css_class'   => 'question-circle',
							  'module_title'=> 'FAQ'];

		$arr_final_tile[] = ['module_slug'  => 'site_settings',
							  'css_class'   => 'wrench',
							  'module_title'=> 'Site Settings'];

		$arr_final_tile[] = ['module_slug'  => 'users',
							  'css_class'   => 'users',
							  'module_title'=> 'Users'];


		$arr_final_tile[] = ['module_slug'  => 'categories',
							  'css_class'   => 'list-alt',
							  'module_title'=> 'Categories'];

		$arr_final_tile[] = ['module_slug'  => 'states',
							  'css_class'   => 'location-arrow',
							  'module_title'=> 'States'];

		$arr_final_tile[] = ['module_slug'  => 'cities',
							  'css_class'   => 'map-marker',
							  'module_title'=> 'Cities'];

		$arr_final_tile[] = ['module_slug'  => 'countries',
							  'css_class'   => 'globe',
							  'module_title'=> 'Countries'];

		$arr_final_tile[] = ['module_slug'  => 'keyword_translation',
							  'css_class'   => 'language',
							  'module_title'=> 'Keyword Translation'];					  

		return 	$arr_final_tile;						  
    }

    

}

