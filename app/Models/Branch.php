<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Branch extends Authenticatable
{
    use HasFactory;

    const DIR_STORAGE = 'storage/branches/';
    const DIR_PUBLIC = 'branches/';

    protected $hidden = ['id','customer_id'];

    protected $guarded = [];

    protected $casts = ['status'=>'boolean'];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function creviews()
    {
        return $this->morphMany(CustomerReview::class, 'creviewable');
    }

    public function customer()
    {
        return $this->belongsTO(Customer::class);
    }

}
