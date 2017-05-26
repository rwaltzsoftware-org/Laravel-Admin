<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class TalukaTranslationModel extends Model
{
	use Rememberable;
    protected $table = 'talukas_translation';
    protected $fillable = [
    							'taluka_id',
    							'title',
    							'locale',
    						];
}
