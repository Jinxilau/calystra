<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotographerAvailability extends Model
{
    protected $fillable = [
        'photographer_id',
        'date',
        'start_time',
        'end_time',
        'is_available',
        'reason'
    ];

    public function photographer()
    {
        return $this->belongsTo(Photographer::class);
    }

    // public function booking()
    // {
    //     return $this->belongsTo(Booking::class);
    // }
}
