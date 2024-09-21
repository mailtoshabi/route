<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    use HasFactory;

    const DIR_STORAGE = 'storage/drivers/';
    const DIR_PUBLIC = 'drivers/';

    protected $hidden = [
        'password',
        'id',
    ];

    protected $guarded = [];

    public function reviews() {
        return $this->hasMany(DriverReview::class);
    }

    public function driverable()
    {
        return $this->morphTo();
    }

    public function deliveries() {
        return $this->hasMany(Delivery::class);
    }

    public function getMyReviewAttribute() {
        $total_reviews = $this->reviews()->sum('rating');
        $review_count = $this->reviews()->count();
        $my_review = $review_count==0? 0 : $total_reviews/$review_count;
        return floor($my_review);
    }
}
