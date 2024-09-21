<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FaqType extends Model
{
    use HasFactory;

    const DIR_STORAGE = 'storage/faq_types/';
    const DIR_PUBLIC = 'faq_types/';

    protected $hidden = ['id'];

    protected $guarded = [];

    protected $casts = ['status'=>'boolean'];

    /**
     * Boot the model.
     */


    public function faqs() {
        return $this->hasMany(Faq::class, 'faq_type_id');
    }

}
