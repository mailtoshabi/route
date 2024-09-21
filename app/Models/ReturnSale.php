<?php

namespace App\Models;

use App\Http\Utilities\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnSale extends Model
{
    use HasFactory;

    protected $hidden = ['id'];

    protected $guarded = [];

    protected $casts = ['is_driver_accept' => 'boolean'];

    public function seller() {
        return $this->belongsTo(Customer::class, 'seller_id', 'id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function deliveries()
    {
        return $this->morphMany(Delivery::class, 'deliverable');
    }

    public function product_sale()
    {
        return $this->belongsTO(ProductSale::class);
    }

}
