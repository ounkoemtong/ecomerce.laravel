<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItemModel::class, 'order_id');
    }
}
