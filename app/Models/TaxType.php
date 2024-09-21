<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'perc',
        'user_id',
    ];

    public  function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function products() {
        return $this->hasMany(Product::class, 'tax_type_id');
    }

}
