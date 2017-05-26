<?php

namespace App\Models; 
use \Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Watson\Rememberable\Rememberable;

class CategoryModel extends Eloquent
{
    use Rememberable;
	use Translatable;

    protected $table = 'categories'; 

    /* Translatable Config */
    public $translationModel      = 'App\Models\CategoryTranslationModel';
    public $translationForeignKey = 'category_id';
    public $translatedAttributes  = ['category_title','category_slug','locale'];
    protected $fillable           = ['image','parent','is_active'];


    public function parent_category()
    {
    	return $this->belongsTo('App\Models\CategoryModel','parent','id');
    }

    public function child_category()
    {
        return $this->hasMany('App\Models\CategoryModel','parent','id');
    }

    public function delete()
    {
        $this->translations()->delete();
        return parent::delete();
    }  
}
