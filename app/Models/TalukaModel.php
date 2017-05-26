<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

use \Dimsav\Translatable\Translatable;

class TalukaModel extends Model
{
    use Rememberable,Translatable;
    
    public $translationModel      = 'App\Models\TalukaTranslationModel';
    public $translationForeignKey = 'taluka_id';
    public $translatedAttributes  = ['title'];

    
	//use SoftDeletes;
    protected $table    = 'talukas';
    protected $fillable = ['district_id','country_id','state_id','is_active'];

    public function country_details()
    {
        return $this->belongsTo('App\Models\CountryModel','country_id','id');
    } 

    public function state_details()
    {
        return $this->belongsTo('App\Models\StateModel','state_id','id');
    }

    public function district_details()
    {
        return $this->belongsTo('App\Models\DistrictModel','district_id','id');
    }
    
    public function delete()
    {
        $this->translations()->delete();
        return parent::delete();
    }

}
