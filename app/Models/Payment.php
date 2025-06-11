<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    // app/Models/Payment.php
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
