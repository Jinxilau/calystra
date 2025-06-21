<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotographerAvailability extends Model
{
    protected $fillable = [
        'photographer_id',
        'start_date',
        'end_date',
        'reason'
        // 'is_available',
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
