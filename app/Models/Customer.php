<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const DIR_STORAGE = 'storage/customers/';
    const DIR_PUBLIC = 'customers/';

    protected $hidden = [
        'password',
        'id',
        'remember_token',
        'user_id',
        'is_seller',
        'verified_by',
        'lang'
    ];

    protected $cast = [
        'is_seller' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    protected $guarded = [];

    protected $appends = ['name'];

    public function customer_addresses() {
        return $this->hasMany(CustomerAddress::class, 'customer_id', 'id');
    }

    public function branches() {
        return $this->hasMany(Branch::class, 'customer_id', 'id');
    }

    public function getNameAttribute() {
        return $this->first_name. ' ' . $this->last_name;
    }

    public function reviews() {
        return $this->hasMany(CustomerReview::class);
    }

    public function tickets() {
        return $this->hasMany(CustomerTicket::class);
    }

    public function getMyReviewAttribute() {
        $total_reviews = $this->reviews()->sum('rating');
        $review_count = $this->reviews()->count();
        $my_review = $review_count==0? 0 : $total_reviews/$review_count;
        return round($my_review, 2);
    }

    public function adresses() {
        return $this->hasMany(CustomerAddress::class);
    }

    public function adresse_default() {
        return $this->hasOne(CustomerAddress::class)->where('default',1);
    }


}
