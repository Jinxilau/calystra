<?php

namespace App\Livewire;

use App\Models\Booking;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BookingForm extends Component
{
    #[Validate('required|string|max:100')]
    public $customer_name = '';

    // #[Validate('required|email|max:255')]
    // public $customer_email = '';

    #[Validate('required|string|max:20')]
    public $customer_phone = '';
    
    // Event Details
    #[Validate('required|string|in:wedding,corporate,family,portrait,event,other')]
    public $event_type = '';

    #[Validate('required|date|after:today')]
    public $event_date = '';

    #[Validate('required|date_format:H:i')]
    public $event_time = '';

    #[Validate('nullable|string|max:255')]
    public $event_location = '';

    #[Validate('required|string|max:100')]
    public $event_name = '';

    #[Validate('nullable|integer|min:1|max:1000')]
    public $guest_count = '';

    #[Validate('required|string|in:pending,paid,partial')]
    public $deposit_status = 'pending';

    #[Validate('nullable|string|max:1000')]
    public $notes = '';

    public function mount() // Initialize component
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->customer_name = $user->name;
        }
    }

    public function submitForm()
    {
        $validatedData = $this->validate();

        try {
            // Create the booking with validated data
            Booking::create([
                'user_id' => Auth::id(), // Associate with logged-in user if available
                'event_type' => $this->event_type,
                'event_date' => $this->event_date,
                'event_time' => $this->event_time,
                'event_location' => $this->event_location,
                'event_name' => $this->event_name,
                'guest_count' => $this->guest_count,
                'deposit_status' => $this->deposit_status,
                'notes' => $this->notes,
                'status' => 'pending', // Default booking status
            ]);

            // Reset form fields after successful submission
            $this->resetForm();

            // Flash success message
            session()->flash('success', 'Booking request submitted successfully! We will contact you shortly.');

            // Optionally dispatch browser event for additional frontend handling
            $this->dispatch('booking-created');

        } catch (\Exception $e) {
            // Handle any errors during booking creation
            session()->flash('error', 'Something went wrong. Please try again.');
            
        }
    }

    public function resetForm()
    {
        $this->reset([
            'customer_name',
            'customer_email', 
            'customer_phone',
            'event_type',
            'event_date',
            'event_time',
            'event_location',
            'event_name',
            'guest_count',
            'notes'
        ]);
        
        // Keep deposit_status as pending
        $this->deposit_status = 'pending';
    }

    public function getEventTypesProperty() // Computed property for event types and no parameters
    {
        return [
            'wedding' => 'Wedding Photography',
            'corporate' => 'Corporate Events',
            'family' => 'Family Portraits',
            'portrait' => 'Individual Portraits',
            'event' => 'General Events',
            'other' => 'Other'
        ];
    }

    public function render()
    {
        return view('livewire.booking-form', [
            'eventTypes' => $this->eventTypes, // Use computed property for event types
        ]);
    }

}
