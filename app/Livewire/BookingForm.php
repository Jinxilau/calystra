<?php

namespace App\Livewire;

use App\Models\Booking;
use Livewire\Component;

class BookingForm extends Component
{
    public $name;
    public $email;
    public $phone;
    public $date;
    public $time; 

    protected $fillable = ['name', 'email', 'phone', 'date', 'time'];
    
    public $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'date' => 'required|date',
        'time' => 'required|string|max:10',
    ];

    public function submitForm()
    {
        sleep(10);
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
