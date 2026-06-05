<?php

namespace Database\Seeders;

use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeader extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       RoleModel::create([
        "name"=>"admin",
       ]);

       RoleModel::create([
        "name"=>"user"
       ]);
    }
}
