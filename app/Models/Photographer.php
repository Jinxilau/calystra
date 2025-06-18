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
        'bio',
        'profile_photo',
        'is_active',
        // 'hourly_rate'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function availability()
    {
        return $this->hasMany(PhotographerAvailability::class);
    }

    
    //
}
