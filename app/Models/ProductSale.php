<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;
    protected $table = 'product_sale';
    protected $cast = ['starts_at'=>'date','ends_at'=>'date'];
    protected $hidden = ['id','sale_id','product_id','rent_term_id','vat','is_refundable','date_ready','date_accepted','date_dispatched','date_out_delivery','date_delivered','date_closed','date_onhold','date_cancelled','status','status_delivery','status_pickup','created_at','updated_at'];
    protected $guarded = [];

    public function sale_return() {
        return $this->hasOne(ReturnSale::class,'product_sale_id', 'id');
    }

    public function product()
    {
        return $this->belongsTO(Product::class);
    }

    public function sale()
    {
        return $this->belongsTO(Sale::class);
    }

    public function deliveries()
    {
        return $this->morphMany(Delivery::class, 'deliverable');
    }

    public function planners()
    {
        return $this->hasMany(Planner::class);
    }

    public function getEncryptedIdAttribute () {
        return encrypt($this->id);
    }

    protected $appends = ['encrypted_id'];

    public function getPaymentTextAttribute() {
        if($this->is_paid) return '<span class="badge badge-pill badge-soft-success font-size-12">Paid</span>';
        else return '<span class="badge badge-pill badge-soft-danger font-size-12">Not Paid</span>';
    }

}
