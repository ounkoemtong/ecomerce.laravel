<?php

namespace Database\Seeders;

use App\Models\WishListModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishListSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WishListModel::create([
            "user_id"=>2,
            "product_id"=>2,

        ]);
         WishListModel::create([
            "user_id"=>2,
            "product_id"=>2,

        ]);
         WishListModel::create([
            "user_id"=>2,
            "product_id"=>1,

        ]);
        
    }
}
