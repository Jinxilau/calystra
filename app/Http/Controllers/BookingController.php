<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(
            'user:id,fullname',
            'bookingAddOns:id,booking_id,add_on_id,quantity',
            'bookingAddOns.addOn:id,name,description'
        )
            ->select('id', 'user_id', 'event_type', 'event_date', 'start_time', 'event_location', 'guest_count', 'status');


        $search = $request->get('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('event_type', 'like', "%{$search}%")
                    ->orWhere('event_location', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('fullname', 'like', "%{$search}%");
                    });
            });
        }

        // Sort by nearest or farthest
        if ($request->get('sort') == 'nearest') {
            $query->orderBy('event_date', 'asc');
        } elseif ($request->get('sort') == 'farthest') {
            $query->orderBy('event_date', 'desc');
        }

        // Filter by event type
        $filterType = $request->get('type');
        if ($filterType) {
            $query->where('event_type', $filterType);
        }

        // Get bookings after applying filters
        $bookings = $query->get();

        // Get distinct event types for dropdown
        $events = Booking::select('event_type')->distinct()->pluck('event_type');

        return view('admin.manageBooking', compact('bookings', 'events', 'filterType'));
    }

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
    