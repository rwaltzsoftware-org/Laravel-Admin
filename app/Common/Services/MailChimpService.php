<?php 

namespace App\Common\Services;

use App\Model\SiteSettingModel;

class MailChimpService
{
	private $obj_mailchimp;
    private $list_id;
    private $api_key;

    public function __construct()
    {  
        $site_settings = SiteSettingModel::where('site_settting_id','1')->remember(30)->first();

        /* Fallback Credentials */
        $this->api_key = "77305b05561118a9ccbdc671ad2f34a3-us13";   
        $this->list_id = "277dfef0f2";

        /* SiteSettings Mailchimp Credentials */
        if($site_settings)
        {
            $this->api_key = $site_settings->mailchimp_api_key;   
            $this->list_id = $site_settings->mailchimp_list_id;
        }
    }

    public function subscribe($email)
    {
    	$arr_merges = [];
    	$email_type = true;
    	$double_optin=false;
        $update_existing=false;
        $replace_interests=true;
        $send_welcome=false;
        
        $data = array(
                'email_address'=>$email,
                'apikey'=>$this->api_key,
                'merge_vars' => $arr_merges,
                'id' => $this->list_id,
                'double_optin' => $double_optin,
                'update_existing' => $update_existing,
                'replace_interests' => $replace_interests,
                'send_welcome' => $send_welcome,
                'email_type' => $email_type
            );
        $payload = json_encode($data);
         
        //replace us2 with your actual datacenter
        $submit_url = "http://us13.api.mailchimp.com/1.3/?method=listSubscribe";
         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $submit_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
         
        $result = curl_exec($ch);
        curl_close ($ch);
        $data = json_decode($result);
        if (isset($data->error))
        {
            return FALSE;
        } 
        else 
        {
            return TRUE;
        }	
    }
}