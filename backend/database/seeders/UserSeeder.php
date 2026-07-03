<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            "name" => "tingtong",
            "email" => "tingtong@gmail.com",
            "phone" => "012345678",
            "role_id" => 1,
            "status" => "active",
            "password" => bcrypt("tingtong@1234"),
            
        ]);

        User::create([
            "name" => "lida",
            "email" => "lida@gmail.com",
            "phone" => "098765432",
            "role_id" => 2,
            "status" => "active",
            "password" => bcrypt("lida@1234"),
        ]);
    }
}