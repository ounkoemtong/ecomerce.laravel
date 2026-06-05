<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressesModel extends Model
{
    protected $table="addresses";
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'province',
        'city',
        'district',
        'address_line',
        'is_default',
    ];
}
