<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentTerm extends Model
{
    use HasFactory;
    protected $hidden = ['id'];

    protected $guarded = [];

    protected $casts = ['status'=>'boolean'];
}
