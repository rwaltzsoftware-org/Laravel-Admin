<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class FAQTranslationModel extends Model
{
    use Rememberable;
    protected $table = 'faq_translation';
    protected $fillable = ['faq_id', 'question', 'answer', 'locale'];
}
