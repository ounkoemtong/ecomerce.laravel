<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingModel extends Model
{
    protected $table='shippings';
    protected $fillable = [
        'order_id',
        'courier_name',
        'tracking_number',
        'shipping_status',
        'shipped_at',
        'delivered_at',
        



    ];
}
