<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $casts = ['delivery_est_at'=>'datetime'];
    protected $guarded = [];

    public function driver()
    {
        return $this->belongsTO(Driver::class);
    }

    public function deliverable()
    {
        return $this->morphTo();
    }

}
