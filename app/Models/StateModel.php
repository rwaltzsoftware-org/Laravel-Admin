<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

use \Dimsav\Translatable\Translatable;

class StateModel extends Model
{
    use Translatable,Rememberable;
    

	//use SoftDeletes;
    protected $table = 'state';
    protected $fillable = ['public_key', 'state_slug','country_id','is_active'];
    public $translationModel = 'App\Models\StateTranslationModel';
    public $translationForeignKey = 'state_id';
    public $translatedAttributes = ['state_title','locale'];

    public function country_details()
    {
        return $this->belongsTo('App\Models\CountryModel','country_id','id');
    }    

    public function cities()
    {
        return $this->hasMany('App\Models\CityModel','state_id','id');
    }

    public function delete()
    {
        $this->translations()->delete();
        $this->cities()->delete();
        return parent::delete();
    }
}
