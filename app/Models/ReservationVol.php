<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationVol extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'places',
        'priceTotal',
        'vol_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
