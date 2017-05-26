<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

use \Dimsav\Translatable\Translatable;

class DistrictModel extends Model
{
    use Rememberable,Translatable;
    
    public $translationModel = 'App\Models\DistrictTranslationModel';
    public $translationForeignKey = 'district_id';
    public $translatedAttributes = ['title'];


    
	//use SoftDeletes;
    protected $table = 'districts';
    protected $fillable = ['country_id','state_id','is_active'];

    public function country_details()
    {
        return $this->belongsTo('App\Models\CountryModel','country_id','id');
    } 

    public function state_details()
    {
        return $this->belongsTo('App\Models\StateModel','state_id','id');
    }

    public function taluka_details()
    {
        return $this->hasMany('App\Models\TalukaModel','district_id','id');
    }
    
    public function delete()
    {
        $this->translations()->delete();
        return parent::delete();
    }

}
