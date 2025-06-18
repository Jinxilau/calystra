<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BookingPhotographer extends Pivot
{
    protected $fillable = [
        'assigned_by',
        'booking_id',
        'photographer_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function photographer()
    {
        return $this->belongsTo(Photographer::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
