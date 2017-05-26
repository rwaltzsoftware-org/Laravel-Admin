<?php
namespace App\Common\Services;

use App\Models\LanguageModel;
class LanguageService
{
    public function get_all_language()
    {
        $arr_lang = array();
        $obj_res = LanguageModel::where('status','1')->get();
        if( $obj_res != FALSE)
        {
            $arr_lang = $obj_res->toArray();

        }
        return $arr_lang;
    }
}