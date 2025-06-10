<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Attributes\Rule;
use Livewire\Component;

class BookingForm extends Component
{
    #[Rule('required|string|max:255')]
    public $name;
    #[Rule('required|email|unique:bookings,email|max:255')]
    public $email;
    #[Rule('required|string|max:255')]
    public $phone;
    #[Rule('required|date_format:Y-m-d|after_or_equal:today|max:255')]
    public $date;
    #[Rule('required|date_format:H:i|max:255')]
    public $time; 
    
    public function submitForm()
    {
        $this->validate();

        // Here you would typically save the booking to the database
        Booking::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'date' => $this->date,
            'time' => $this->time,
        ]);
        // Reset form fields
        $this->reset(['name', 'email', 'phone', 'date', 'time']);
        
        session()->flash('success', 'Booking successfully created.');
        
    }
    
    public function render()
    {
        $bookings = Booking::all();
        return view('livewire.booking-form', [
            'bookings' => $bookings,
        ]);
    }
}
