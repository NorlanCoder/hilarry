<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vol extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'airport_start',
        'airport_end',
        'volStart',
        'volEnd',
        'places',
        'price',
    ];
}
