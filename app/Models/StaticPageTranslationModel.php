<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

class StaticPageTranslationModel extends Model
{
	use Rememberable;
    protected $table='static_pages_translation';
   
    public $timestamps = false;
    protected $fillable = ['id','page_title','page_desc','static_page_id','locale','meta_keyword','meta_desc'];

}
