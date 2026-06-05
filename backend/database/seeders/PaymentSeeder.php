<?php

namespace Database\Seeders;

use App\Models\PaymentModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentModel::create([
            'order_id' => 1,
            'payment_method' => 'ABA',
            'transaction_id' => 'TRX123456',
            'amount' => 115.00,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        PaymentModel::create([
            'order_id' => 2,
            'payment_method' => 'Cash On Delivery',
            'transaction_id' => null,
            'amount' => 238.00,
            'status' => 'pending',
            'paid_at' => null,
        ]);

        PaymentModel::create([
            'order_id' => 3,
            'payment_method' => 'Credit Card',
            'transaction_id' => 'TRX999888',
            'amount' => 460.00,
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }
}
