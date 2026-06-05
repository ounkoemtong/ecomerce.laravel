<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\AddressesModel;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AddressesModel::create([
            'user_id' => 1,
            'full_name' => 'John Doe',
            'phone' => '012345678',
            'province' => 'Phnom Penh',
            'city' => 'Chamkar Mon',
            'district' => 'Tonle Bassac',
            
            'address_line' => 'Street 271, House 12',
            'is_default' => true,
        ]);

        AddressesModel::create([
            'user_id' => 2,
            'full_name' => 'Jane Smith',
            'phone' => '098765432',
            'province' => 'Kandal',
            'city' => 'Ta Khmau',
            'district' => 'Takhmao',
           
            'address_line' => 'Street 21B, House 45',
            'is_default' => false,
        ]);

        AddressesModel::create([
            'user_id' => 2,
            'full_name' => 'David Kim',
            'phone' => '011223344',
            'province' => 'Siem Reap',
            'city' => 'Siem Reap City',
            'district' => 'Svay Dangkum',
            
            'address_line' => 'Near Old Market',
            'is_default' => true,
        ]);
    }
}