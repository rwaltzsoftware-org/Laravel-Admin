<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class DistrictTranslationModel extends Model
{
	use Rememberable;
    protected $table = 'districts_translation';
    protected $fillable = [
    							'district_id',
    							'title',
    							'locale',
    						];
}
