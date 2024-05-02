<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationHebergement extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'places',
        'date',
        'priceTotal',
        'hebergement_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
