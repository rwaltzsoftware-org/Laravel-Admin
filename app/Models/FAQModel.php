<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Dimsav\Translatable\Translatable;
use Watson\Rememberable\Rememberable;

class FAQModel extends Model
{
    use Rememberable;
	use Translatable;

	protected $table = 'faq';

    public $translationModel = 'App\Models\FAQTranslationModel';
 	public $translationForeignKey = 'faq_id';
    public $translatedAttributes = ['question','answer'];

    protected $fillable = ['id', 'is_active'];

    public function delete()
    {
        $this->translations()->delete();
        return parent::delete();
    }
}
