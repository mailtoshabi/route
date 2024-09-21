<?php

namespace App\Models;

use App\Http\Utilities\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function faq_type()
    {
        return $this->belongsTO(FaqType::class, 'faq_type_id', 'id');
    }

    public function scopeOpen($query) {
        return $query->where('status',Utility::ITEM_ACTIVE);
    }

    public function scopeClosed($query) {
        return $query->where('status',Utility::ITEM_INACTIVE);
    }
}
