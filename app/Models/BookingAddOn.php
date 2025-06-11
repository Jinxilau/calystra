<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingAddOn extends Model
{
    //
    // app/Models/AddOn.php
    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_add_ons')
            ->withPivot('quantity', 'unit_price', 'total_price')
            ->withTimestamps();
    }
}
