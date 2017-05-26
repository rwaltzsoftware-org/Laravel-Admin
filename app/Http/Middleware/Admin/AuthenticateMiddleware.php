<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Sentinel;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $arr_except = array();

        $admin_path = config('app.project.admin_panel_slug');

        $arr_except[] =  $admin_path;
        $arr_except[] =  $admin_path.'/login';
        $arr_except[] =  $admin_path.'/process_login';
        $arr_except[] =  $admin_path.'/forgot_password';
        $arr_except[] =  $admin_path.'/process_forgot_password';
        $arr_except[] =  $admin_path.'/validate_admin_reset_password_link';
        $arr_except[] =  $admin_path.'/reset_password';
        
        /*-----------------------------------------------------------------
            Code for {enc_id} or {extra_code} in url
        ------------------------------------------------------------------*/
        $request_path = $request->route()->getCompiled()->getStaticPrefix();
        $request_path = substr($request_path,1,strlen($request_path));
        
        /*-----------------------------------------------------------------
                End
        -----------------------------------------------------------------*/        

        if(!in_array($request_path, $arr_except))
        {
            $user = Sentinel::check();
            if($user)
            {
                if($user->inRole('admin'))
                {
                    return $next($request);    
                }
                else
                {
                    return redirect('/admin');
                }    
            }
            else
            {
                return redirect('/admin');
            }
            
        }
        else
        {
            return $next($request); 
        }
    }
}
