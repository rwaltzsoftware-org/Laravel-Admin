<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Common\Traits\MultiActionTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactEnquiryModel extends Model
{
    use SoftDeletes;

    protected $table = "contact_enquiry";

    protected $fillable = ['user_name','email','phone','subject','comments','is_view'];

    public function delete()
    {
    	
    	parent::delete();
    }
}
