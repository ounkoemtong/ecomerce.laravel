<?php

namespace Database\Seeders;

use App\Models\ShippingModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          ShippingModel::create([
            'order_id' => 1,
            'courier_name' => 'J&T Express',
            'tracking_number' => 'TRK123456',
            'shipping_status' => 'delivered',
            'shipped_at' => now(),
            'delivered_at' => now(),
        ]);

        ShippingModel::create([
            'order_id' => 2,
            'courier_name' => 'Cambodia Post',
            'tracking_number' => 'TRK789456',
            'shipping_status' => 'in_transit',
            'shipped_at' => now(),
            'delivered_at' => null,
        ]);

        ShippingModel::create([
            'order_id' => 3,
            'courier_name' => 'DHL',
            'tracking_number' => 'TRK555999',
            'shipping_status' => 'pending',
            'shipped_at' => null,
            'delivered_at' => null,
        ]);
    }
}
