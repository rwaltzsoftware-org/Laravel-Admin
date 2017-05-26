<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

class LanguageModel extends Model
{
	use Rememberable;
    protected $table = 'language';
   
}
