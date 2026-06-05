<?php

namespace Database\Seeders;

use App\Models\OrderModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderModel::create([
            'user_id' => 1,
            'address_id' => 1,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'subtotal' => 120.00,
            'discount' => 10.00,
            'shipping_fee' => 5.00,
            'total' => 115.00,
            'payment_status' => 'paid',
            'order_status' => 'processing',
            'payment_method' => 'cash_on_delivery',
        ]);

        OrderModel::create([
            'user_id' => 2,
            'address_id' => 2,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'subtotal' => 250.00,
            'discount' => 20.00,
            'shipping_fee' => 8.00,
            'total' => 238.00,
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'payment_method' => 'aba',
        ]);

        OrderModel::create([
            'user_id' => 2,
            'address_id' => 3,
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'subtotal' => 500.00,
            'discount' => 50.00,
            'shipping_fee' => 10.00,
            'total' => 460.00,
            'payment_status' => 'paid',
            'order_status' => 'delivered',
            'payment_method' => 'credit_card',
        ]);
    }
}