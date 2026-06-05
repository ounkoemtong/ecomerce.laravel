<?php

namespace Database\Seeders;

use App\Models\OrderItemModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         OrderItemModel::create([
            'order_id' => 1,
            'product_id' => 1,
            'product_name' => 'MacBook Pro M4',
            'price' => 2500,
            'quantity' => 1,
            'total' => 2500,
        ]);

        OrderItemModel::create([
            'order_id' => 1,
            'product_id' => 2,
            'product_name' => 'iPhone 15 Pro',
            'price' => 1200,
            'quantity' => 2,
            'total' => 2400,
        ]);
    }
}
