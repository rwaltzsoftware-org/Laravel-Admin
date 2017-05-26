<?php


function translation($keyword=false)
{
	if($keyword!=false)
	{
		$locale          = \Session::get('locale');
		$translated_word = '';

		if(\Cache::has('translation_data')==false)
		{
			get_translation_data();
		}

		/*--------------------------------------------------------------------
		|Fetched locale wise translation data from cache file
		--------------------------------------------------------------------*/
		$arr_translation_data = \Cache::get('translation_data')[$locale];
		/*------------------------------------------------------------------*/

		if(isset($arr_translation_data) && sizeof($arr_translation_data)>0)
		{
			$translated_word = isset($arr_translation_data[$keyword])&&sizeof($arr_translation_data[$keyword])?$arr_translation_data[$keyword]:'###';	

			/*----------------------------------------------------------------
			|Check if locale wise title exist, If not then fetched default 
			|English title for that keyword 
			-----------------------------------------------------------------*/
			if(isset($arr_translation_data[$keyword]) && sizeof($arr_translation_data[$keyword]) && $arr_translation_data[$keyword]==null)
			{
				$arr_translation_data = \Cache::get('translation_data')['en'];

				$translated_word = $arr_translation_data[$keyword];
			}
			/*---------------------------------------------------------------*/
		}

		return $translated_word;
	}
	return false;
}

function get_translation_data()
{
	$arr_translation = [];
    $obj_translation = \App\Models\KeywordTranslationModel::get();
    if($obj_translation)
    {
       $arr_translation = $obj_translation->toArray();

       /*-----------------------------------------------------------------------------------------
       |Rearrange array in local wise
       -----------------------------------------------------------------------------------------*/
       if(isset($arr_translation) && sizeof($arr_translation)>0)
       {
       		$tmp_arr = [];
       		foreach($arr_translation as $key => $translation)
       		{
       			$tmp_arr[$translation['locale']][$key] = [$translation['keyword'],$translation['title']];
       		}
       }
       /*---------------------------------------------------------------------------------------*/

       /*-----------------------------------------------------------------------------------------
       |Rearrange array in local wise and keyword with title
       -----------------------------------------------------------------------------------------*/
       $final_arr = [];
       if(isset($tmp_arr) && sizeof($tmp_arr)>0)
       {
       		foreach ($tmp_arr as $key => $value) 
       		{
       			$keyword_arr = array_column($value,null,0);

       			foreach($keyword_arr as $keyword => $data)
       			{
       				$final_arr[$key][$keyword] = $data[1];
       			}
       		}
       }
       /*----------------------------------------------------------------------------------------*/
    	
       \Cache::put('translation_data',$final_arr,21600);/*21600 minutes for 15 days*/
    }
    return false;
}
		
?>