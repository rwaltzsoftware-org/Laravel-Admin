<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

use \Dimsav\Translatable\Translatable;

class CityModel extends Model
{
    use Rememberable,Translatable;
    
    public $translationModel = 'App\Models\CityTranslationModel';
    public $translationForeignKey = 'city_id';
    public $translatedAttributes = ['city_title'];


    
	//use SoftDeletes;
    protected $table = 'city';
    protected $fillable = ['public_key', 'city_slug','country_id','state_id','is_active'];

    public function country_details()
    {
        return $this->belongsTo('App\Models\CountryModel','country_id','id');
    } 

    public function state_details()
    {
        return $this->belongsTo('App\Models\StateModel','state_id','id');
    }
    
    public function delete()
    {
        $this->translations()->delete();
        return parent::delete();
    }

}
