<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = [
        'user_id',
        'photographer_id',
        'event_type',
        'event_date',
        'start_time',
        'event_location',
        'event_name',
        'guest_count',
        'status',
        'deposit_status',
        'notes',
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
            ->withPivot('quantity', 'unit_price', 'total_price')
            ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // public function gallery()
    // {
    //     return $this->hasOne(Gallery::class);
    // }

    // Helper methods
    public function getTotalPaidAttribute()
    {
        return $this->payments()->where('status', 'completed')->sum('amount');
    }

    public function getBalanceAttribute()
    {
        return $this->total_amount - $this->total_paid;
    }
}
