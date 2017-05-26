<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
/*admin_panel_slug = admin*/
$admin_path = config('app.project.admin_panel_slug');

Route::group(['middleware' => ['web']], function ()  use($admin_path) 
{
	/* Admin Routes */
	Route::group(['prefix' => $admin_path,'middleware'=>['admin']], function () 
	{

		Route::group(array('prefix' => '/common'), function()
		{
			Route::get('get_states/{country_id}',['as' => 'get_states' ,'uses' => 'Common\LocationController@get_states']);
			Route::get('get_districts/{state_id}',['as' => 'get_districts' ,'uses' => 'Common\LocationController@get_districts']);
			Route::get('get_taluka/{district_id}',['as' => 'get_taluka' ,'uses' => 'Common\LocationController@get_taluka']);
			Route::get('get_category/{category_id}',['as' => 'get_states' ,'uses' => 'Common\LocationController@get_sub_category']);
			Route::get('get_goods/{category_id}',['as' => 'get_states' ,'uses' => 'Common\LocationController@get_goods']);		
		});
		
		$route_slug       = "admin_auth_";
		$module_controller = "Admin\AuthController@";

		/* Admin Auth Routes Starts */

		Route::get('/',               ['as'=>$route_slug.'login',          'uses'=>$module_controller.'login']);	
		Route::get('login',           ['as'=>$route_slug.'login',          'uses'=>$module_controller.'login']);	
		Route::post('process_login',  ['as'=>$route_slug.'process_login',  'uses'=>$module_controller.'process_login']);	
		Route::get('change_password', ['as'=>$route_slug.'change_password','uses'=>$module_controller.'change_password']);	
		Route::post('update_password',['as'=>$route_slug.'change_password' ,'uses'=>$module_controller.'update_password']);	
		Route::post('process_forgot_password',['as'=>$route_slug.'forgot_password','uses'=>$module_controller.'process_forgot_password']);
		Route::get('validate_admin_reset_password_link/{enc_id}/{enc_reminder_code}', 	['as'=>$route_slug.'validate_admin_reset_password_link', 'uses' => $module_controller.'validate_reset_password_link']);
		Route::post('reset_password',['as'=>$route_slug.'reset_passsword','uses'=>$module_controller.'reset_password']);
		
		/* Dashboard */
		Route::get('/dashboard',['as'=>$route_slug.'dashboard','uses'=>'Admin\DashboardController@index']);	
		Route::get('/logout',   ['as'=>$route_slug.'logout',   'uses'=>$module_controller.'logout']);	

		/*Account Settings*/

		$account_setting_controller = "Admin\AccountSettingsController@";

		Route::get('account_settings',                  ['as' => $route_slug.'account_settings_show',   'uses' => $account_setting_controller.'index']);
		Route::post('account_settings/update/{enc_id}', ['as' => $route_slug.'account_settings_update', 'uses' => $account_setting_controller.'update']);
		
		/* Admin Language Phrase Routes Starts */

		Route::group(['prefix'=>'language_phrase'],function()
		{
			$route_slug       = "admin_language_phrase_";
			$module_controller = "Admin\LanguagePhraseController@";

			Route::get('/',                       ['as'=>$route_slug.'index',		 	  'uses'=>$module_controller.'index']);	
			Route::get('create/{enc_id?}',        ['as'=>$route_slug.'create',		 	  'uses'=>$module_controller.'create']);	
			Route::post('store',                  ['as'=>$route_slug.'store',	 	 	  'uses'=>$module_controller.'store']);	
			Route::get('edit/{enc_id}',           ['as'=>$route_slug.'edit',		 	  'uses'=>$module_controller.'edit']);	
			Route::post('update/{enc_id}',        ['as'=>$route_slug.'update',		 	  'uses'=>$module_controller.'update']);	
			Route::get('delete/{enc_id}',         ['as'=>$route_slug.'delete',		 	  'uses'=>$module_controller.'delete']);	
			Route::get('activate/{enc_id}',       ['as'=>$route_slug.'activate',	 	  'uses'=>$module_controller.'activate']);	
			Route::get('deactivate/{enc_id}',     ['as'=>$route_slug.'deactivate',	 	  'uses'=>$module_controller.'deactivate']);	
			Route::post('multi_action',           ['as'=>$route_slug.'multi_action',	  'uses'=>$module_controller.'multi_action']);	
				

		});

		/* Admin Categories Routes Starts */

		Route::group(['prefix'=>'categories'],function()
		{
			$route_slug       = "admin_category_";
			$module_controller = "Admin\CategoryController@";

			Route::get('/',                       ['as'=>$route_slug.'index',		 	  'uses'=>$module_controller.'index']);	
			Route::get('/sub_categories/{enc_id}',['as'=>$route_slug.'subcategory_index','uses'=>$module_controller.'index_sub_category']);	
			Route::get('create/{enc_id?}',        ['as'=>$route_slug.'create',		 	  'uses'=>$module_controller.'create']);	
			Route::post('store',                  ['as'=>$route_slug.'store',	 	 	  'uses'=>$module_controller.'store']);	
			Route::get('edit/{enc_id}',           ['as'=>$route_slug.'edit',		 	  'uses'=>$module_controller.'edit']);	
			Route::post('update/{enc_id}',        ['as'=>$route_slug.'update',		 	  'uses'=>$module_controller.'update']);	
			Route::get('delete/{enc_id}',         ['as'=>$route_slug.'delete',		 	  'uses'=>$module_controller.'delete']);	
			Route::get('activate/{enc_id}',       ['as'=>$route_slug.'activate',	 	  'uses'=>$module_controller.'activate']);	
			Route::get('deactivate/{enc_id}',     ['as'=>$route_slug.'deactivate',	 	  'uses'=>$module_controller.'deactivate']);	
			Route::post('multi_action',           ['as'=>$route_slug.'multi_action',	  'uses'=>$module_controller.'multi_action']);	
			
			Route::get('/get_records',            ['as' => $route_slug.'get_records', 'uses' => $module_controller.'get_records']);
		});

		/*--------------------------------------------Activity_log----------------------*/

		Route::group(array('prefix' => '/activity_logs'), function()
		{
			$route_slug        = "activity_logs_";
			$module_controller = "Admin\ActivityLogController@";

			Route::get('/',['as' => $route_slug.'index', 'uses' => $module_controller.'index']);
			Route::get('/get_records',['as' => $route_slug.'get_records', 'uses' => $module_controller.'get_records']);

	 	});
		
		/*------------------------- Admin Contries Related ------------------------------*/


		Route::group(array('prefix' => '/countries'), function()
		{
			$route_slug       = "admin_countries_";
			$module_controller = "Admin\CountryController@";

			Route::get('/',					 ['as' => $route_slug.'manage',	  'uses' => $module_controller.'index']);
			Route::get('show/{enc_id}',		 ['as' => $route_slug.'show',		  'uses' => $module_controller.'show']);
			Route::get('edit/{enc_id}',		 ['as' => $route_slug.'edit',	      'uses' => $module_controller.'edit']);
			Route::post('update/{enc_id}',	 ['as' => $route_slug.'update',	  'uses' => $module_controller.'update']);
			Route::get('create',			 ['as' => $route_slug.'create', 	  'uses' => $module_controller.'create']);
			Route::any('store',				 ['as' => $route_slug.'store',	  	  'uses' => $module_controller.'store']);
			Route::get('delete/{enc_id}',	 ['as' => $route_slug.'delete',	  'uses' => $module_controller.'delete']);
			Route::get('activate/{enc_id}',  ['as' => $route_slug.'activate',    'uses' => $module_controller.'activate']);	
			Route::get('deactivate/{enc_id}',['as' => $route_slug.'deactivate',  'uses' => $module_controller.'deactivate']);
			Route::post('multi_action',		 ['as' => $route_slug.'multi_action','uses' => $module_controller.'multi_action']);
		});
		/*-----------------------------------------------------------------------------*/

		/*-----------------------Contact Enquiry---------------------------------------*/

			Route::group(array('prefix'=>'/contact_enquiry'), function () 
			{
				$route_slug       = "admin_contact_enquiry_";
				$route_controller = "Admin\ContactEnquiryController@";

				Route::get('/',['as' => $route_slug.'index',
								'uses' => $route_controller.'index']);

				Route::get('/view/{enc_id}',['as' => $route_slug.'details',
											 'uses' => $route_controller.'view']);

				Route::get('delete/{enc_id}',['as' => $route_slug.'delete',
											  'uses' => $route_controller.'delete']);

				Route::post('multi_action',['as'=> $route_slug.'multi_action',
											'uses'=> $route_controller.'multi_action']);	
			});

		/*-----------------------------------------------------------------------------*/

		/*----------------------Admin - FAQ Module-------------------------------------*/

		Route::group(array('prefix' => '/faq'), function()
		{
			$route_slug       = 'admin_faq_';
			$route_controller = 'Admin\FAQController@';

			Route::get('/',['as' => $route_slug.'index', 
							'uses' => $route_controller.'index']);
			
			Route::get('/create',['as' => $route_slug.'create', 
								  'uses' => $route_controller.'create']);

			Route::post('/store',['as' => $route_slug.'store', 
								  'uses' => $route_controller.'store']);

			Route::get('/edit/{enc_id}',['as' => $route_slug.'edit', 
										 'uses' => $route_controller.'edit']);

			Route::post('/update/{enc_id}',['as' => $route_slug.'update', 
										 	'uses' => $route_controller.'update']);

			Route::get('/delete/{enc_id}',['as' => $route_slug.'edit', 
										   'uses' => $route_controller.'delete']);

			Route::get('activate/{enc_id}',['as' => $route_slug.'activate',
											'uses' => $route_controller.'activate']);	

			Route::get('deactivate/{enc_id}',['as' => $route_slug.'deactivate',
											  'uses' => $route_controller.'deactivate']);

			Route::post('multi_action',['as' => $route_slug.'multi_action',
										'uses' => $route_controller.'multi_action']);
	 		
		});


		/*-----------------------------------------------------------------------------*/

		/*------------------------- Admin states Related ------------------------------*/

		Route::group(array('prefix' => '/states'), function()
		{
			$route_slug       = "admin_states_";
			$module_controller = "Admin\StateController@";
			
			Route::get('/',					 ['as' => $route_slug.'manage',	  'uses' => $module_controller.'index']);
			Route::get('show/{enc_id}',		 ['as' => $route_slug.'show',		  'uses' => $module_controller.'show']);
			Route::get('edit/{enc_id}',		 ['as' => $route_slug.'edit',		  'uses' => $module_controller.'edit']);
			Route::post('update/{enc_id}',	 ['as' => $route_slug.'update',	  'uses' => $module_controller.'update']);
			Route::get('create',		     ['as' => $route_slug.'create',	  'uses' => $module_controller.'create']);
			
			Route::post('/store',['as' => $route_slug.'store', 
								  'uses' => $module_controller.'store']);
			
			Route::get('delete/{enc_id}',	 ['as' => $route_slug.'delete',	  'uses' => $module_controller.'delete']);
			Route::get('activate/{enc_id}',  ['as' => $route_slug.'activate',    'uses' => $module_controller.'activate']);	
			Route::get('deactivate/{enc_id}',['as' => $route_slug.'deactivate',  'uses' => $module_controller.'deactivate']);
			Route::post('multi_action',		 ['as' => $route_slug.'multi_action','uses' => $module_controller.'multi_action']);
			
		}); 

		/*-----------------------------------------------------------------------------------*/

		/*------------------------- Admin Cities Related ------------------------------*/

		Route::group(array('prefix' => '/cities'), function()
		{
			$route_slug       = "admin_cities_";
			$module_controller = "Admin\CityController@";

			Route::get('/',					 ['as' => $route_slug.'manage',	  'uses' => $module_controller.'index']);
			Route::get('show/{enc_id}',		 ['as' => $route_slug.'show',		  'uses' => $module_controller.'show']);
			Route::get('edit/{enc_id}',		 ['as' => $route_slug.'edit',		  'uses' => $module_controller.'edit']);
			Route::post('update/{enc_id}',	 ['as' => $route_slug.'update',	  'uses' => $module_controller.'update']);
			Route::get('create',			 ['as' => $route_slug.'create',	  'uses' => $module_controller.'create']);
			Route::any('store',			 	 ['as' => $route_slug.'store',		  'uses' => $module_controller.'store']);
			Route::get('delete/{enc_id}',	 ['as' => $route_slug.'delete',	  'uses' => $module_controller.'delete']);
			Route::get('activate/{enc_id}',	 ['as' => $route_slug.'activate', 	  'uses' => $module_controller.'activate']);	
			Route::get('deactivate/{enc_id}',['as' => $route_slug.'deactivate',  'uses' => $module_controller.'deactivate']);
			Route::post('multi_action',		 ['as' => $route_slug.'multi_action','uses' => $module_controller.'multi_action']);
	 		
		}); 

		/*----------------------------------------------------------------------------------------
			Admin Roles
		----------------------------------------------------------------------------------------*/

			Route::group(array('prefix' => '/admin_users'), function()
			{
				$route_slug       = "admin_users_";
				$module_controller = "Admin\AdminUserController@";

				Route::get('/',				   ['as' => $route_slug.'index',  'uses' => $module_controller.'index']);
				Route::get('/create',		   ['as' => $route_slug.'create', 'uses' => $module_controller.'create']);
				Route::post('/store',		   ['as' => $route_slug.'store',  'uses' => $module_controller.'store']);
				Route::get('/edit/{enc_id}',   ['as' => $route_slug.'edit',   'uses' => $module_controller.'edit']);
				Route::post('/update/{enc_id}',['as' => $route_slug.'update', 'uses' => $module_controller.'update']);
				Route::get('/delete/{enc_id}', ['as' => $route_slug.'edit',   'uses' => $module_controller.'delete']);	
			});

		/*---------------------------------------------------------------------------------------
			End
		-----------------------------------------------------------------------------------------*/

		/*----------------------------------------------------------------------------------------
			Static Pages - CMS
		----------------------------------------------------------------------------------------*/

			Route::group(array('prefix' => '/static_pages'), function()
			{
				$route_slug       = "static_pages_";
				$module_controller = "Admin\StaticPageController@";

				Route::get('/', 				 ['as' => $route_slug.'manage',	  'uses' => $module_controller.'index']);
				Route::get('create',			 ['as' => $route_slug.'create',	  'uses' => $module_controller.'create']);
				Route::get('edit/{enc_id}',		 ['as' => $route_slug.'edit',		  'uses' => $module_controller.'edit']);
				Route::any('store',				 ['as' => $route_slug.'store',		  'uses' => $module_controller.'store']);
				Route::post('update/{enc_id}',	 ['as' => $route_slug.'update',	  'uses' => $module_controller.'update']);
				Route::get('delete/{enc_id}',	 ['as' => $route_slug.'delete',	  'uses' => $module_controller.'delete']);	
				Route::get('activate/{enc_id}',  ['as' => $route_slug.'activate',	  'uses' => $module_controller.'activate']);	
				Route::get('deactivate/{enc_id}',['as' => $route_slug.'deactivate',  'uses' => $module_controller.'deactivate']);	
				Route::post('multi_action',		 ['as' => $route_slug.'multi_action','uses' => $module_controller.'multi_action']);	


			});

		/*---------------------------------------------------------------------------------------
			End
		-----------------------------------------------------------------------------------------*/

		/*----------------------------------------------------------------------------------------
			Email Template
		----------------------------------------------------------------------------------------*/

			Route::group(array('prefix' => '/email_template'), function()
			{	
				$route_slug       = "admin_email_template_";
				$module_controller = "Admin\EmailTemplateController@";

				Route::get('/',				  ['as' => $route_slug.'index', 'uses' => $module_controller.'index']);
				Route::get('create/',		  ['as' => $route_slug.'create','uses' => $module_controller.'create']);
				Route::post('store/',		  ['as' => $route_slug.'store', 'uses' => $module_controller.'store']);
				Route::get('edit/{enc_id}',	  ['as' => $route_slug.'edit',	 'uses' => $module_controller.'edit']);
				Route::get('view/{enc_id}',	  ['as' => $route_slug.'edit',	 'uses' => $module_controller.'view']);
				Route::post('update/{enc_id}',['as' => $route_slug.'update','uses' => $module_controller.'update']);
			});

		/*---------------------------------------------------------------------------------------
			End
		-----------------------------------------------------------------------------------------*/

		/*----------------------------------------------------------------------------------------
			Site Settings
		----------------------------------------------------------------------------------------*/

			Route::get('site_settings', 				 ['as' => 'site_settings', 'uses' => 'Admin\SiteSettingController@index']);
			Route::post('site_settings/update/{enc_id}', ['as' => 'site_settings', 'uses' => 'Admin\SiteSettingController@update']);

		/*---------------------------------------------------------------------------------------
			End
		-----------------------------------------------------------------------------------------*/

		/*----------------------------------------------------------------------------------------
			User Module
		----------------------------------------------------------------------------------------*/

			Route::group(array('prefix' => '/users'), function()
			{	
				$route_slug       = "admin_traveller_";
				$module_controller = "Admin\UserController@";

				Route::get('/',					['as' => $route_slug.'index',		 'uses' => $module_controller.'index']);
				Route::get('create/',			['as' => $route_slug.'create',		 'uses' => $module_controller.'create']);
				Route::post('store/',			['as' => $route_slug.'store',		 'uses' => $module_controller.'store']);
				Route::get('edit/{enc_id}',		['as' => $route_slug.'edit',		 'uses' => $module_controller.'edit']);
				Route::post('update',			['as' => $route_slug.'update',		 'uses' => $module_controller.'update']);
				Route::get('activate/{enc_id}', ['as' => $route_slug.'activate',	 'uses' => $module_controller.'activate']);	
				Route::get('deactivate/{enc_id}',['as'=> $route_slug.'deactivate',	 'uses' => $module_controller.'deactivate']);
				Route::post('multi_action', 	['as' => $route_slug.'multi_action','uses' => $module_controller.'multi_action']);
				Route::get('delete/{enc_id}',	['as' => $route_slug.'update',		 'uses' => $module_controller.'delete']);
				
				Route::get('/get_records',['as' => $route_slug.'get_records', 'uses' => $module_controller.'get_records']);
			});

		/*---------------------------------------------------------------------------------------
			End
		-----------------------------------------------------------------------------------------*/

		/*---------------------------------------------------------------------------------------
		|	Keyword translation
		-----------------------------------------------------------------------------------------*/

		Route::group(['prefix'=>'keyword_translation'],function()
		{
			$route_slug        = "keyword_translation_";
			$module_controller = "Admin\KeywordTranslationController@";

			Route::get('/',['as'=>$route_slug.'index',
							 	    'uses'=>$module_controller.'index']);

			Route::get('get_records',['as' => $route_slug.'get_records',
							 			'uses' => $module_controller.'get_records']);

			/*Route::get('get_records',['as' => $route_slug.'get_records',
							 			'uses' => $module_controller.'get_records']);*/

			Route::get('edit/{enc_id}',['as' => $route_slug.'edit',
							 			'uses' => $module_controller.'edit']);

			Route::post('update/',['as' => $route_slug.'update',
													   'uses' => $module_controller.'update']);

			Route::get('create/',['as' => $route_slug.'create',
									  'uses' => $module_controller.'create']);

			Route::post('store/',['as' => $route_slug.'store',
				 					  'uses' => $module_controller.'store']);

		});	

		/*---------------------------------------------------------------------------------------
		|	End
		-----------------------------------------------------------------------------------------*/


	});	    
});
