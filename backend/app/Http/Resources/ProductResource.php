<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hasDiscount = $this->discount_price !== null && $this->discount_price < $this->price;
        $finalPrice = $hasDiscount ? $this->price - $this->discount_price : $this->price;

        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => (float) $this->price,
            'discount_price' => $this->discount_price === null ? null : (float) $this->discount_price,
            'final_price' => (float) $finalPrice,
            'stock_qty' => (int) $this->stock_qty,
            'sku' => $this->sku,
            'image' => $this->image,
            'status' => $this->status,
            'has_discount' => $hasDiscount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
