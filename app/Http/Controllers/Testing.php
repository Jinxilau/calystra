<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class Testing extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'photographers'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.managePhotographer', compact('bookings'));
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load([
            'user', 
            'photographers', 
            'bookingPhotographers.photographer',
            'bookingPhotographers.assignedBy'
        ]);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'event_type' => 'required|string|max:255',
            'event_date' => 'required|date|after:today',
            'start_time' => 'required',
            'event_location' => 'nullable|string',
            'event_name' => 'nullable|string|max:255',
            'guest_count' => 'nullable|integer|min:1',
            'status' => 'required|in:pending,approved,denied',
            'notes' => 'nullable|string'
        ]);

        $booking->update($validated);

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully!');
    }

    /**
     * Approve the specified booking.
     */
    public function approve(Booking $booking)
    {
        $booking->update(['status' => 'approved']);

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking approved successfully!');
    }

    /**
     * Deny the specified booking.
     */
    public function deny(Booking $booking)
    {
        $booking->update(['status' => 'denied']);

        // Optional: Remove photographer assignments when booking is denied
        $booking->photographers()->detach();

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking denied successfully!');
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }

}
