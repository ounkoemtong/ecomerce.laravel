<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table ='orders';
    protected $fillable = [ 
        'user_id',
        'address_id',
        'order_number',
        'subtotal',
        'discount',
        'shipping_fee',
        'total',
        'payment_status',
        'order_status',
        'payment_method',

    ];
}
