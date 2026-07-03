<?php

namespace Database\Seeders;

use App\Models\CategoryModel;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryModel::create([
            "name" => "New Season",
            "slug" => "new-season",
            "description" => "Latest arrivals and fresh trends for the season.",
            "status" => "active",
        ]);

        CategoryModel::create([
            "name" => "Outerwear",
            "slug" => "outerwear",
            "description" => "Tailored wool coats, classic trench coats, and layering essentials.",
            "status" => "active",
        ]);

        CategoryModel::create([
            "name" => "Footwear",
            "slug" => "footwear",
            "description" => "Italian crafted leather boots, minimal sandals, and refined heels.",
            "status" => "active",
        ]);

        CategoryModel::create([
            "name" => "Accessories",
            "slug" => "accessories",
            "description" => "Structural bags, handcrafted jewelry, and signature accents.",
            "status" => "active",
        ]);
    }
}

