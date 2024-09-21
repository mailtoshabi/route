<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    const DIR_STORAGE = 'storage/vehicles/';
    const DIR_PUBLIC = 'vehicles/';

    protected $hidden = ['id'];

    protected $guarded = [];

    protected $casts = ['status' => 'boolean','expiry' => 'date'];

    public function driver()
    {
        return $this->belongsTO(Driver::class);
    }
}
