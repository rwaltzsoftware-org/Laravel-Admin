<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class CityTranslationModel extends Model
{
	use Rememberable;
    protected $table = 'city_translation';
    protected $fillable = [
    							'city_id',
    							'city_title',
    							'city_slug',
    							'locale',
    						];
}
