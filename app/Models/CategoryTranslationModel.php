<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

class CategoryTranslationModel extends Model 
{
	use Rememberable;
	
	protected $table    = 'categories_translation';	
	public $timestamps  = false;
	protected $fillable = ['id','category_title','category_slug','category_id','locale'];
	
}