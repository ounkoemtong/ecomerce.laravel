<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $table = "Product";
    protected $fillable = [
        'name',
        'age',
        'phone'
    ];
}
