<?php

namespace Database\Seeders;

use App\Models\BrandModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BrandModel::create([
            "name"=>"Apple",
            'slug'=>"apple",
            "status"=>"active"

        ]);
        BrandModel::create([
            "name"=>"Oppo",
            'slug'=>"oppo",
            "status"=>"active"

        ]);
        BrandModel::create([
            "name"=>"vivo",
            'slug'=>"vivo",
            "status"=>"active"

        ]);
    }
}
