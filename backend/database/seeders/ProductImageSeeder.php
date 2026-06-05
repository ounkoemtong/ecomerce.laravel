<?php

namespace Database\Seeders;

use App\Models\ProductImageModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    
   
    public function run(): void
    {
        ProductImageModel::create([
            'product_id'=>3,
            "image"=>'https://i.pinimg.com/736x/af/85/67/af8567110396b1d2137b02898dfae29c.jpg',
        ]);
        
        ProductImageModel::create([
            'product_id'=>2,
            "image"=>'https://i.pinimg.com/736x/6f/36/41/6f3641b2e63cd934e6f52b856070e12f.jpg',
        ]);
    }
}
