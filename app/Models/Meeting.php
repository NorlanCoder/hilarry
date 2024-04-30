<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'localisation',
        'capacity',
        'equipments',
        'services',
    ];

    protected $casts = [
        'equipments' => 'array',
        'services' => 'array'
    ];

}
