<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\Pivot;

class BookingAddOn extends Model
{
    protected $fillable = [
        'booking_id',
        'add_on_id',
        'quantity',
        // 'unit_price',
        // 'total_price',
        'notes'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }
}
