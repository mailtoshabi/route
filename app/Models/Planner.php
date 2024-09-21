<?php

namespace App\Models;

use App\Http\Utilities\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Planner extends Model
{
    use HasFactory;

    protected $casts = ['action_date'=>'date'];
    protected $guarded = [];
    protected $hidden = ['id','product_sale_id','type','action_date','status','created_at','updated_at'];
    protected $appends = ['date'];

    public function product_sale()
    {
        return $this->belongsTO(ProductSale::class, 'product_sale_id', 'id');
    }

    public function getYearAttribute() {
        $date = Carbon::parse($this->action_date);
        $year = $date->year;
        return $year;
    }

    public function getMonthAttribute() {
        $date = Carbon::parse($this->action_date);
        $month = $date->month;
        return $month;
    }

    public function getDayAttribute() {
        $date = Carbon::parse($this->action_date);
        $day = $date->day;
        return $day;
    }

    public function getDateAttribute() {
        $date = Carbon::parse($this->action_date);
        $formattedDate = $date->format('d-m-Y');
        return $formattedDate;
    }

    public function scopeActive($query) {
        return $query->where('status',Utility::ITEM_ACTIVE);
    }

    public function scopeInactive($query) {
        return $query->where('status',Utility::ITEM_INACTIVE);
    }


}
