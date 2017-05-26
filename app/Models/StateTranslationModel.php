<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class StateTranslationModel extends Model
{
	use Rememberable;
    protected $table = 'state_translation';
    protected $fillable = [
    							'state_id',
    							'state_title',
    							'locale',
    						];
}
