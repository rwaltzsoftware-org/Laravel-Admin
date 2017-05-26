<?php

namespace App\Models;

use \Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Watson\Rememberable\Rememberable;

class StaticPageModel extends Eloquent
{
	use Rememberable;
	use Translatable;
    protected $table = 'static_pages';

       /* Translatable Config */
    public $translationModel 	  = 'App\Models\StaticPageTranslationModel';
    public $translationForeignKey = 'static_page_id';
    public $translatedAttributes  = ['page_title','page_desc','meta_desc','locale','meta_keyword'];
    protected $fillable 		  = ['page_slug','is_active'];

}


