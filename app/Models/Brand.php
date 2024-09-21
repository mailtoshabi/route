<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    const DIR_STORAGE = 'storage/brands/';
    const DIR_PUBLIC = 'brands/';

    protected $hidden = ['id'];

    protected $fillable = [
        'name', 'name_ar', 'image', 'user_id', 'status','slug'
    ];

    protected $casts = ['status'=>'boolean'];

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

    public function products() {
        return $this->hasMany(Product::class,'product_id', 'id');
    }
}
