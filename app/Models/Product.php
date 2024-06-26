<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\ProductVariation;
use App\Models\ProductCategory;


class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'base_price',
        'price',
        'category_id',
        'image',
        'sku',
        'quantity',
        'variation',
        // Add other fillable fields here
    ];

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
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
        return asset('storage/product/' . $this->attributes['image']);
    }

}