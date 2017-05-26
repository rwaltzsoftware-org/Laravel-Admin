<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class CountryTranslationModel extends Model
{
	use Rememberable;
    protected $table = 'countries_translation';
    protected $fillable = [
    							'country_id',
    							'country_name',
    							'country_slug',
    							'locale',
    						];
}
