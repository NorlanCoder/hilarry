<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'picture',
        'price',
        'cookTime',
        'type',
        'is_blocked',
        'is_recommanded'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
