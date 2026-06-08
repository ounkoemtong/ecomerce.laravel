<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductModel extends Model

{
  use HasFactory;
    protected $table="products";
    protected $fillable = [
    'category_id',
    'brand_id',
    'name',
    'slug',
    'description',
    'price',
    'discount_price',
    'stock_qty',
    'sku',
    'image',
    'status',
];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImageModel::class, 'product_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartModel::class, 'product_id');
    }

}
