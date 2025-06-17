<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user:id,fullname')
        ->select('id', 'event_type', 'event_date','start_time', 'event_location', 'guest_count', 'status')->get();
        return view('admin.manageBooking', compact('bookings'));
    }
}
