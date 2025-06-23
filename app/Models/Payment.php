<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'booking_id',
        'amount',
        'receipt_path',
        // 'payment_type',
        // 'payment_method',
        // 'status',
        // 'admin_notes',
    ];
    // app/Models/Payment.php
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // public function verifiedBy()
    // {
    //     return $this->belongsTo(User::class, 'verified_by');
    // }
}
