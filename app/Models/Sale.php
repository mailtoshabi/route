<?php

namespace App\Models;

use App\Http\Utilities\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $hidden = ['id','customer_id','customer_address_id','status','created_at','updated_at','is_delivery','delivery_charge_total'];

    protected $guarded = [];

    protected $casts = ['date_processing' => 'datetime','date_dispatched' => 'datetime','date_delivered' => 'datetime','date_onhold' => 'datetime','date_replaced' => 'datetime','date_cancelled' => 'datetime'];

    public function customer()
    {
        return $this->belongsTO(Customer::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class,'product_sale')->withPivot('id','invoice_no','rent_term_id','price','vat','starts_at','ends_at','status')->withTimestamps();
    }

    public function product_sales() {
        return $this->hasMany(ProductSale::class);
    } // Created to make seeder

    public function getPaymentMethodTextAttribute() {
        if($this->pay_method==Utility::PAYMENT_ONLINE) return '<i class="fab fa-cc-visa me-1"></i> Online Payment';
        else if($this->pay_method==Utility::PAYMENT_COD) return '<i class="fas fa-money-bill-alt me-1"></i> Cash On Delivery';
        else return '-';
    }

    public function scopeActive($query) {
        return $query->where('status',Utility::ITEM_ACTIVE);
    }

    public function scopeArchive($query) {
        return $query->where('status',Utility::ITEM_INACTIVE);
    }
}
