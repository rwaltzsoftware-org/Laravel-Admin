<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class LanguagePhraseModel extends Model
{
    use Rememberable;

	protected $table = 'language_phrases';

    protected $fillable = ['id', 'phrase','content','locale'];

    public function delete()
    {
        return parent::delete();
    }
}
