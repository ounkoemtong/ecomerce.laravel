<?php

namespace Database\Seeders;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryModel::create([
            "name"=>"coca",
            "slug"=>"coca",
            "description"=>"hello god",
            "status"=>"active",
        ]);
        CategoryModel::create([
            "name"=>"pepsi",
            "slug"=>"pepsi",
            "description"=>"hello god",
            "status"=>"active",
        ]);
    }
}
