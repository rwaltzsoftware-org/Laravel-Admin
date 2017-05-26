<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class ActivityLogsModel extends Model
{
    use Rememberable;

    protected $table      = "activity_log";
    protected $primaryKey = 'id';
    protected $fillable   = ['module_title','module_action','user_id'];
}
