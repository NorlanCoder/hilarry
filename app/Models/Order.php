<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shopping',
        'pay',
        'transaction',
    ];

    protected $casts = [
        'shopping' => 'array',
        'transaction' => 'array'
    ];
}
