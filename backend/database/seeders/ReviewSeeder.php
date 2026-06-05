<?php

namespace Database\Seeders;

use App\Models\ReviewModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         ReviewModel::create([
            'user_id' => 1,
            'product_id' => 1,
            'order_id' => 1,
            'rating' => 5,
            'comment' => 'Very good product',
            'status' => 'approved',
        ]);

        ReviewModel::create([
            'user_id' => 2,
            'product_id' => 2,
            'order_id' => 2,
            'rating' => 4,
            'comment' => 'Nice quality',
            'status' => 'approved',
        ]);

        ReviewModel::create([
            'user_id' => 2,
            'product_id' => 3,
            'order_id' => 3,
            'rating' => 2,
            'comment' => 'Delivery was slow',
            'status' => 'pending',
        ]);
    }
}
