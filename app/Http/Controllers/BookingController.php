<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user:id,fullname')
            ->select('id', 'user_id', 'event_type', 'event_date', 'start_time', 'event_location', 'guest_count', 'status')->get();
        return view('admin.manageBooking', compact('bookings'));
    }

    // public function destroy()
    // {
    //     $booking = Booking::findOrFail($id);
    //     $booking->delete();

    //     return redirect()->back()->with('success', 'Booking deleted successfully.');
    // }

    public function destroy(Request $request)
    {
        $ids = $request->input('selected-booking'); // An array of IDs

        if ($ids && is_array($ids)) {
            Booking::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Selected bookings deleted successfully.');
        }

        return redirect()->back()->with('error', 'No bookings were selected.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,pending,denied',
        ]);

        $booking = Booking::findorFail($id);
        $booking->status = $request->status;
        $booking->save();

        return redirect()->back()->with('success', 'Booking updated successfully');
    }
}
