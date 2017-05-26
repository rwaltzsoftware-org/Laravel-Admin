<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Common\Services\EmailService;

use Validator;
use Flash;
use Sentinel;
use Reminder;
use URL;
use Mail;

class AuthController extends Controller
{
  public function __construct(EmailService $mail_service)
  {
    
    $this->arr_view_data      = [];
    $this->module_title       = "Admin";
    $this->module_view_folder = "admin.auth";
    $this->EmailService       = $mail_service;
    $this->admin_panel_slug   = config('app.project.admin_panel_slug');
    $this->module_url_path    = url($this->admin_panel_slug);
   
    /*----------------Admin Panel Theme Color Helper----------------*/
    $this->theme_color = theme_color();
    /*--------------------------------------------------------------*/      
  }
  
  public function login()
  {
    $this->arr_view_data['module_title']     = $this->module_title." Login";
    $this->arr_view_data['theme_color']      = $this->theme_color;

    return view($this->module_view_folder.'.login',$this->arr_view_data);
  }

  public function process_login(Request $request)
  {
     $validator = Validator::make($request->all(), [
          'email' => 'required|max:255',
          'password' => 'required',
      ]);

      if ($validator->fails()) 
      {
          return redirect(config('app.project.admin_panel_slug').'/login')
                      ->withErrors($validator)
                      ->withInput($request->all());
      }

      $credentials = [
          'email'    => $request->input('email'),
          'password' => $request->input('password'),
      ];

      $check_authentication = Sentinel::authenticate($credentials);

      if($check_authentication)
      {
        $user = Sentinel::check();

        if($user->inRole('admin'))
        {
          return redirect(config('app.project.admin_panel_slug').'/dashboard');
        }
        else
        {
          Flash::error('Not Sufficient Privileges');
          return redirect()->back();
        }

      }
      else
      {
        Flash::error('Invalid Login Credential');
        return redirect()->back();
      }

  }

  public function change_password()
  {
    $this->arr_view_data['page_title']      = $this->module_title." Change Password";
    $this->arr_view_data['module_title']    = $this->module_title." Change Password";
    $this->arr_view_data['module_url_path'] = $this->module_url_path.'/change_password';
    $this->arr_view_data['theme_color']     = $this->theme_color;

    return view($this->module_view_folder.'.change_password',$this->arr_view_data);    
     
  }

  public function update_password(Request $request)
  {
      $arr_rules                     = array();
      $arr_rules['current_password'] = "required";
      $arr_rules['new_password']     = "required|confirmed";
      
      $validator = Validator::make($request->all(),$arr_rules);
      if($validator->fails())
      {
          return redirect()->back()->withErrors($validator)->withInput($request->all());
      }

      
      $user = Sentinel::check();

      $credentials = [];
      $credentials['password'] = $request->input('current_password');

      if (Sentinel::validateCredentials($user,$credentials)) 
      { 
        $new_credentials = [];
        $new_credentials['password'] = $request->input('new_password');

        if(Sentinel::update($user,$new_credentials))
        {
          Flash::success('Password Change Successfully');
        }
        else
        {
          Flash::error('Problem Occurred, While Changing Password');
        }
      } 
      else
      {
        Flash::error('Invalid Old Password');
      }       
      
      return redirect()->back(); 
  }

   public function process_forgot_password(Request $request)
  {

    $arr_rules['email']      = "required";

    $validator = Validator::make($request->all(),$arr_rules);

    if($validator->fails())
    {
      Flash::error('Please enter valid email_id');
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $email = $request->input('email');

    $user  = Sentinel::findByCredentials(['email' => $email]);

    if($user==null)
    {
      Flash::error("Invaild Email Id");
      return redirect()->back();
    }

    if($user->inRole('admin')==false)
    {
      Flash::error('We are unable to process this Email Id');
      return redirect()->back();
    }



    $reminder = Reminder::create($user);


    $arr_mail_data = $this->built_mail_data($email, $reminder->code); 
    $email_status  = $this->EmailService->send_mail($arr_mail_data);

    if($email_status)
    {
      Flash::success('Password reset link send successfully to your email id');
      return redirect()->back();
    }
    else
    {
      Flash::success('Error while sending password reset link');
      return redirect()->back();
    }
  }

  public function built_mail_data($email, $reminder_code)
  {
    $user = $this->get_user_details($email);
    if($user)
    {
        $arr_user = $user->toArray();

        $reminder_url = '<a target="_blank" style="background:#fa8612; color:#fff; text-align:center;border-radius: 4px; padding: 15px 18px; text-decoration: none;" href=" '.URL::to($this->admin_panel_slug.'/validate_admin_reset_password_link/'.base64_encode($arr_user['id']).'/'.base64_encode($reminder_code) ).'">Reset Password</a>.<br/>' ;

        $arr_built_content = ['FIRST_NAME'   => $arr_user['first_name'],
                              'EMAIL'        => $arr_user['email'],
                              'REMINDER_URL' => $reminder_url,
                              'SITE_URL'     => config('app.project.name')];


        $arr_mail_data                      = [];
        $arr_mail_data['email_template_id'] = '7';
        $arr_mail_data['arr_built_content'] = $arr_built_content;
        $arr_mail_data['user']              = $arr_user;

        return $arr_mail_data;
    }
    return FALSE;
  }

  public function get_user_details($email)
  {
    $credentials = ['email' => $email];
    $user = Sentinel::findByCredentials($credentials); // check if user exists

    if($user)
    {
      return $user;
    }
    return FALSE;
  }


  public function validate_reset_password_link($enc_id, $enc_reminder_code)
  {
    $user_id       = base64_decode($enc_id);
    $reminder_code = base64_decode($enc_reminder_code);

    $user = Sentinel::findById($user_id);

    if(!$user)
    {
      Flash::error('Invalid User Request');
      return redirect()->back();
    }

    if($reminder = Reminder::exists($user))
    {
      return view($this->module_view_folder.'.reset_password',compact('enc_id','enc_reminder_code'));
    }
    else
    {
      Flash::error('Reset Password Link Expired');
      return redirect()->back();
    }
  }

  public function reset_password(Request $request)
  {
    $arr_rules                      = array();
    $arr_rules['password']          = "required";
    $arr_rules['confirm_password']  = "required";
    $arr_rules['enc_id']            = "required";
    $arr_rules['enc_reminder_code'] = "required";

    $validator = Validator::make($request->all(),$arr_rules);

    if($validator->fails())
    {
      return redirect()->back();
    }

    $enc_id            = $request->input('enc_id');
    $enc_reminder_code = $request->input('enc_reminder_code');
    $password          = $request->input('password');
    $confirm_password  = $request->input('confirm_password');

    if($password  !=  $confirm_password )
    {
      Flash::error('Passwords Do Not Match.');
      return redirect()->back();
    }

    $user_id       = base64_decode($enc_id);
    $reminder_code = base64_decode($enc_reminder_code);

    $user = Sentinel::findById($user_id);

    if(!$user)
    {
      Flash::error('Invalid User Request');
      return redirect()->back();
    }

    if ($reminder = Reminder::complete($user, $reminder_code, $password))
    {
      Flash::success('Password reset successfully');
      return redirect($this->admin_panel_slug.'/login');
    }
    else
    {
      Flash::error('Reset Password Link Expired');
      return redirect()->back();
    }

  }

  public function logout()
  {
    Sentinel::logout();
    return redirect(url($this->admin_panel_slug));
  }

}
