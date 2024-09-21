<?php

namespace App\Models;

use App\Http\Utilities\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    const DIR_STORAGE = 'storage/products/';
    const DIR_PUBLIC = 'products/';

    // protected $hidden = ['id'];

    protected $hidden = ['id','user_id','name_ar','description_ar','model_year','barcode','is_available','available_at','meta_title','meta_keywords','meta_description','sub_category_id','branch_id','delivery_days','is_featured','is_trending'];
    protected $guarded = [];

    protected $casts = ['status'=>'boolean'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->slug = $model->createSlug($model->name);
            $model->save();
        });
    }

    private function createSlug($name){
        if (static::whereSlug($slug = Str::slug($name))->exists()) {
            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');

            if (is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function ($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }

            return "{$slug}-2";
        }

        return $slug;
    }

    public function sub_category()
    {
        return $this->belongsTO(SubCategory::class, 'sub_category_id', 'id');
    }

    public function scopeActive($query) {
        return $query->where('status',Utility::ITEM_ACTIVE);
    } // TODO: check the how to use it.

    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function sales() {
        return $this->belongsToMany(Sale::class,'product_sale')->withPivot('id','invoice_no','rent_term_id','price','vat','starts_at','ends_at','status')->withTimestamps();
    }

    public function rentTerms() {
        return $this->belongsToMany(RentTerm::class)->withPivot('price')->withTimestamps();
    }

    public function product_reviews() {
        return $this->hasMany(ProductReview::class);
    }

    public function averageReview() {
        return $this->product_reviews()->avg('rating');
    }

    public function getEncryptedIdAttribute () {
        return encrypt($this->id);
    }

}
