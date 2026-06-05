<?php

namespace Database\Seeders;

use App\Models\CartModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CartModel::create([
            "user_id"=>1,
            "product_id"=>2,
            'quantity'=>1,
            "price"=>100,

        ]);
         CartModel::create([
            "user_id"=>2,
            "product_id"=>2,
            'quantity'=>2,
            "price"=>200,

        ]);
         CartModel::create([
            "user_id"=>1,
            "product_id"=>2,
            'quantity'=>1,
            "price"=>200,

        ]);
    }
}
