<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_type',
        'status',
        'start_date',
        'end_date',
        'reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
