<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Shipper extends Authenticatable
{
    use HasFactory;

    const DIR_STORAGE = 'storage/shippers/';
    const DIR_PUBLIC = 'shippers/';

    protected $guarded = [];

    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function drivers()
    {
        return $this->morphMany(Driver::class, 'driverable');
    }
}
