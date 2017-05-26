<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class EmailTemplateModel extends Model
{
	use Rememberable;
	
    protected $table = 'email_template';
    
    protected $fillable = ['template_name', 
    						'template_subject',
    						'template_from',
    						'template_from_mail', 
    						'template_html',
    						'template_variables'
    						];
}
