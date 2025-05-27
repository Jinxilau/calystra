<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;

class BookingForm extends Component
{
    public $name;
    public $event_type; 
    public $event_date;
    
    public $rules = [
        'name' => 'required|string|max:255',
        'event_type' => 'required|string|max:255',
        'event_date' => 'required|date',
    ];

    public function submit()
    {
        $this->validate();

        // Here you would typically save the booking to the database
        Booking::create([
            'name' => $this->name,
            'event_type' => $this->event_type,
            'event_date' => $this->event_date,
        ]);

        session()->flash('message', 'Booking successfully created.');

        // Reset form fields
        $this->reset(['name', 'event_type', 'event_date']);
    }
    
    public function render()
    {
        return view('livewire.booking-form');
    }
}
