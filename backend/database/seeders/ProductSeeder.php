<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           ProductModel::create([
            'category_id' => 1,
            'brand_id' => 1,
            'name' => 'iPhone 15 Pro Max',
            'slug' => 'iphone-15-pro-max',
            'description' => 'Apple flagship smartphone',
            'price' => 1500,
            'discount_price' => 1400,
            'stock_qty' => 10,
            'sku' => 'IPHONE15PM',
            'image' => 'https://i.pinimg.com/736x/af/85/67/af8567110396b1d2137b02898dfae29c.jpg',
            'status' => 'active',
        ]);

        ProductModel::create([
            'category_id' => 1,
            'brand_id' => 2,
            'name' => 'Samsung Galaxy S25',
            'slug' => 'samsung-galaxy-s25',
            'description' => 'Samsung premium smartphone',
            'price' => 1300,
            'discount_price' => 1200,
            'stock_qty' => 15,
            'sku' => 'SAMSUNGS25',
            'image' => 'https://i.pinimg.com/736x/41/61/57/4161572af56a3ed5654a6a48b4d656d7.jpg',
            'status' => 'active',
        ]);

        ProductModel::create([
            'category_id' => 2,
            'brand_id' => 3,
            'name' => 'MacBook Pro M4',
            'slug' => 'macbook-pro-m4',
            'description' => 'Apple powerful laptop',
            'price' => 2500,
            'discount_price' => 2300,
            'stock_qty' => 5,
            'sku' => 'MACBOOKM4',
            'image' => 'https://i.pinimg.com/736x/d7/42/4d/d7424d09f6a9d0f3f7fd73f2d4f3d0e3.jpg',
            'status' => 'active',
        ]);
    }
}
