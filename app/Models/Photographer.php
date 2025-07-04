<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photographer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'profile_photo',
        'is_active',
        // 'bio',
        // 'hourly_rate'
    ];

    public function bookings() // Many-to-many relationship with Booking with the pivot table 'booking_photographer'
    {
        return $this->belongsToMany(Booking::class, 'booking_photographer')
                    ->using(BookingPhotographer::class)
                    ->withPivot('assigned_by')
                    ->withTimestamps();
    }

    public function availability()
    {
        return $this->hasMany(PhotographerAvailability::class);
    }

    //
}
