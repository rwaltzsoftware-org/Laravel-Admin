<?php

namespace App\Common\Services;

use \Cache;
use \Session;
use Carbon\Carbon;

class CurrencyService 
{
	protected 	$from_currency_code,
				$to_currency_code,
				$conversion_rate,
				$cache_timeout,
				$cache_key,
				$cache_data_separator;

	public function __construct()
	{	
		$this->cache_timeout = 60 ; // 60 minutes
		$this->cache_key = "json_currency_conversion";
		$this->cache_data_separator = "~";
	}			


	public function convert($from_currency_code=FALSE,$to_currency_code=FALSE,$amt=FALSE)
	{
		if($from_currency_code==FALSE OR $to_currency_code==FALSE)
		{
			Session::flash('error','From or To Currency Code is Missing');
			return FALSE;
		}

		if($amt==FALSE)
		{
			Session::flash('error','Amount Missing');
			return FALSE;
		}

		$rate = $this->get_conversion_rate($from_currency_code,$to_currency_code);

		$amt = (double) $amt;
		$amt = number_format($amt,2);

		return (double) number_format(($amt*$rate),2);

	}	



	public function get_conversion_rate($from_currency_code=FALSE,$to_currency_code=FALSE)
	{
		if($from_currency_code==FALSE OR $to_currency_code==FALSE)
		{
			Session::flash('error','From or To Currency Code is Missing');
			return FALSE;
		}		

		/* Check if Cache Has given Conversion Rate */

		$cached_rate = $this->_get_conversion_from_cache($from_currency_code,$to_currency_code);

		if($cached_rate!=FALSE)
		{
			return (double)$cached_rate;
		}

		/* if Not Found Then Retrive From API */	
		$rate = $this->_get_conversion_from_api($from_currency_code,$to_currency_code);

		/* Cache the Result */
		$this->_cache_conversion($from_currency_code,$to_currency_code,$rate);
		return (double)$rate;
		
	}

	protected function _get_conversion_from_cache($from_currency_code,$to_currency_code)
	{
		if (Cache::has($this->cache_key)) 
		{
		    $cached_json_currency_data = Cache::get($this->cache_key); 	
		   	$arr_currency_data  = json_decode($cached_json_currency_data,TRUE);

		   	/*
		   		array(
		   				'from_currency_code~to_currency_code' => rate
		   				)
		   		ex.
		   		
		   		array(
						'HRK~INR'=>124
						
		   			)		

		   	*/
		   	
		   	$search_currency_key = $from_currency_code.
		   						   $this->cache_data_separator.
		   						   $to_currency_code;

		   	if(array_key_exists($search_currency_key, $arr_currency_data))
		   	{
		   		return $arr_currency_data[$search_currency_key];
		   	}
		   	else
		   	{
		   		return FALSE;
		   	}
		    
		}
		else
		{
			return FALSE;
		}
		
	}

	public function _get_conversion_from_api($from_currency_code,$to_currency_code)
	{
		$currency_ch = curl_init();
		curl_setopt($currency_ch, CURLOPT_URL, "http://api.fixer.io/latest?base=".$from_currency_code."&symbols=".$to_currency_code);
		curl_setopt($currency_ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($currency_ch);

		$arr_response = json_decode($response,TRUE);

		/* Check if Error in From Currency Code  */	
		if(isset($arr_response['error']))
		{
			Session::flash('error',"Invalid From Currency Code");
			return FALSE;	
		}
		
		/* Check if Error in To Currency Code  */	
		if(isset($arr_response['rates']) && sizeof($arr_response['rates'])==0)
		{
			Session::flash('error',"Invalid To Currency Code");
			return FALSE;	
		}	

		return $arr_response['rates'][$to_currency_code];
	}

	public function _cache_conversion($from_currency_code,$to_currency_code,$rate)
	{	
		$search_currency_key = $from_currency_code.
		   					   $this->cache_data_separator.
		   					   $to_currency_code;

		$to_cache_json_currency_data = "";   					   

		if (Cache::has($this->cache_key)) 
		{
			$cached_json_currency_data = Cache::get($this->cache_key); 	
		   	$arr_currency_data  = json_decode($cached_json_currency_data,TRUE);

		   	
		   	
	   		$arr_currency_data[$search_currency_key] = $rate;

	   		$to_cache_json_currency_data = json_encode($arr_currency_data);
		}
		else
		{
			$arr_currency_data = [];
			$arr_currency_data[$search_currency_key] = $rate;
			$to_cache_json_currency_data = json_encode($arr_currency_data);
			
		}

		return Cache::put($this->cache_key,$to_cache_json_currency_data,$this->cache_timeout);	
	}
}