<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = [
        'user_id',
        'event_type',
        'event_date',
        'start_time',
        'event_location',
        'event_name',
        'guest_count',
        'status',
        'deposit_status',
        'notes',
        // 'assigned_by',
        // 'photographer_id',
    ];

    // app/Models/Booking.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function service()
    // {
    //     return $this->belongsTo(Service::class);
    // }

    public function addOns()
    {
        return $this->belongsToMany(AddOn::class, 'booking_add_ons')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function photographers()
    {
        return $this->belongsToMany(Photographer::class, 'booking_photographer')
            ->withPivot([
                'assigned_by',
            ])
            ->withTimestamps();
    }


    public function payments()
    {
        return $this->hasOne(Payment::class);
    }


    // public function assignedBy()
    // {
    //     return $this->belongsTo(User::class, 'assigned_by');
    // }

    // public function gallery()
    // {
    //     return $this->hasOne(Gallery::class);
    // }

    // Helper methods
    // public function getTotalPaidAttribute()
    // {
    //     return $this->payments()->where('status', 'completed')->sum('amount');
    // }

    public function bookingAddOns()
    {
        return $this->hasMany(BookingAddOn::class);
    }

}
