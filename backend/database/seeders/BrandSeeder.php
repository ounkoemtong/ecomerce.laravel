<?php

namespace Database\Seeders;

use App\Models\BrandModel;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BrandModel::create([
            "name" => "Atelier",
            "slug" => "atelier",
            "logo" => "https://i.pinimg.com/1200x/d7/8e/ea/d78eea976b027c31cee33826cbda41c6.jpg",
            "status" => "active"
        ]);

        BrandModel::create([
            "name" => "Prada",
            "slug" => "prada",
            "logo" => "https://i.pinimg.com/1200x/b6/c8/63/b6c8633f5fdd0eed30f276f603d2038c.jpg",
            "status" => "active"
        ]);

        BrandModel::create([
            "name" => "Celine",
            "slug" => "celine",
            "logo" => "https://i.pinimg.com/1200x/a5/89/c8/a589c8077c7e4735b767a9ffc7ef6c23.jpg",
            "status" => "active"
        ]);

        BrandModel::create([
            "name" => "Toteme",
            "slug" => "toteme",
            "logo" => "https://i.pinimg.com/736x/d0/87/0a/d0870ae0f9799410bb2223a25d48a832.jpg",
            "status" => "active"
        ]);

        BrandModel::create([
            "name" => "Jil Sander",
            "slug" => "jil-sander",
            "logo" => "https://i.pinimg.com/736x/71/ec/3d/71ec3d3020031b2bad3c328f32bb602e.jpg",
            "status" => "active"
        ]);

        BrandModel::create([
            "name" => "Loewe",
            "slug" => "loewe",
            "logo" => "https://i.pinimg.com/736x/8d/f5/e7/8df5e76136dcba44841002494e01e050.jpg",
            "status" => "active"
        ]);

        BrandModel::create([
            "name" => "Burberry",
            "slug" => "burberry",
            "logo" => "https://i.pinimg.com/1200x/3b/53/dc/3b53dccd2c35bbf666e3ea67724aaf22.jpg",
            "status" => "active"
        ]);

        BrandModel::create([
            "name" => "Bottega",
            "slug" => "bottega",
            "logo" => "https://i.pinimg.com/736x/7c/ea/2a/7cea2a785e3f6fdac5f6e57c905dcdbd.jpg",
            "status" => "active"
        ]);
    }
}


