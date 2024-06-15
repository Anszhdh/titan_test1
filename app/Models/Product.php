<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\ProductCategory;

class Product extends Model
{
    use HasFactory;
    
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }    
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset('product/' . $this->attributes['image']);
    }

}