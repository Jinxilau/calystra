<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'price',
        'type', // extra_hour, prints, album, etc.
        'is_active',
    ];

    // app/Models/AddOn.php
    public function bookings() 
    {
        return $this->belongsToMany(Booking::class, 'booking_add_ons')
            ->using(BookingAddOn::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function bookingAddOns()
    {
        return $this->hasMany(BookingAddOn::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
