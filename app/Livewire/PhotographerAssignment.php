<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Photographer;
use App\Models\BookingPhotographer;
use App\Models\PhotographerAvailability;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PhotographerAssignment extends Component
{
    public $booking;
    
    // Photographer
    public $selectedPhotographers = [];
    public $availablePhotographers = [];

    // View
    public $showModal = false;
    public $searchTerm = '';
    public $specializationFilter = '';
    public $showAvailabilityDetails = [];

    protected $rules = [
        'selectedPhotographers' => 'required|array|min:1',
        'selectedPhotographers.*' => 'exists:photographers,id'
    ];

    protected $messages = [
        'selectedPhotographers.required' => 'Please select at least one photographer.',
        'selectedPhotographers.min' => 'Please select at least one photographer.'
    ];

    public function mount(Booking $booking)
    {
        $this->booking = $booking;
        $this->loadAvailablePhotographers();
        $this->loadCurrentAssignments();
    }

    public function loadCurrentAssignments()
    {
        $this->selectedPhotographers = $this->booking->photographers()->pluck('photographers.id')->toArray();
    }

    public function loadAvailablePhotographers()
    {
        $eventStart = Carbon::parse($this->booking->event_date . ' ' . $this->booking->start_time); // '2025-06-21 14:30:00'

        // Assuming 8-hour event duration
        $eventEnd = $eventStart->copy()->addHours(8);

        $query = Photographer::where('is_active', true);

        // Apply search filter
        if ($this->searchTerm) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Apply specialization filter
        if ($this->specializationFilter) {
            $query->where('specialization', 'like', '%' . $this->specializationFilter . '%');
        }

        $photographers = $query->get(); // Execute the query and fetch the result

        $this->availablePhotographers = $photographers->map(function ($photographer) use ($eventStart, $eventEnd) {
            $isAvailable = $this->checkPhotographerAvailability($photographer, $eventStart, $eventEnd);
            $conflicts = $this->getPhotographerConflicts($photographer, $eventStart, $eventEnd);
            
            return [
                'id' => $photographer->id,
                'name' => $photographer->name,
                'email' => $photographer->email,
                'phone' => $photographer->phone,
                'specialization' => $photographer->specialization,
                'profile_photo' => $photographer->profile_photo,
                'is_available' => $isAvailable,
                'conflicts' => $conflicts,
                'availability_status' => $isAvailable ? 'Available' : 'Conflicts Found' // If conflict then conflics found
            ];
        })->toArray();
    }

    private function checkPhotographerAvailability($photographer, $eventStart, $eventEnd)
    {
        // Check if photographer has any conflicting bookings
        $conflictingBookings = BookingPhotographer::where('photographer_id', $photographer->id)
            ->whereHas('booking', function ($query) use ($eventStart, $eventEnd) {
                $query->where('status', '!=', 'denied')
                    ->where(function ($q) use ($eventStart, $eventEnd) {
                        $q->whereRaw('DATE(event_date) = ?', [$eventStart->toDateString()]);
                    });
            })->exists();

        // Check photographer availability table
        $unavailablePeriods = PhotographerAvailability::where('photographer_id', $photographer->id)
        ->where(function ($query) use ($eventStart, $eventEnd) {
            $query->where(function ($q) use ($eventStart, $eventEnd) {
                $q->where('start_date', '<=', $eventStart)
                ->where('end_date', '>=', $eventStart);
            })->orWhere(function ($q) use ($eventStart, $eventEnd) {
                $q->where('start_date', '<=', $eventEnd)
                ->where('end_date', '>=', $eventEnd);
            })->orWhere(function ($q) use ($eventStart, $eventEnd) {
                $q->where('start_date', '>=', $eventStart)
                ->where('end_date', '<=', $eventEnd);
            });
        })->exists();

        return !$conflictingBookings && !$unavailablePeriods; // Returns true only when both is true.
    }

    private function getPhotographerConflicts($photographer, $eventStart, $eventEnd)
    {
        $conflicts = [];

        // Check conflicting bookings
        $conflictingBookings = BookingPhotographer::where('photographer_id', $photographer->id)
            ->whereHas('booking', function ($query) use ($eventStart, $eventEnd) {
                $query->where('status', '!=', 'denied')
                    ->where('id', '!=', $this->booking->id) // Exclude current booking
                    ->where(function ($q) use ($eventStart, $eventEnd) {
                        $q->whereRaw('DATE(event_date) = ?', [$eventStart->toDateString()]);
                    });
            })->with('booking')->get();

        foreach ($conflictingBookings as $bookingPhotographer) {
            $conflicts[] = [
                'type' => 'booking',
                'details' => 'Conflicting booking: #' . $bookingPhotographer->booking->id ." ". $bookingPhotographer->booking->event_name . ' on ' . $bookingPhotographer->booking->event_date
            ];
        }

        // Check unavailable periods
        $unavailablePeriods = PhotographerAvailability::where('photographer_id', $photographer->id)
            ->where(function ($query) use ($eventStart, $eventEnd) {
                $query->where(function ($q) use ($eventStart, $eventEnd) {
                    $q->where('start_date', '<=', $eventStart)
                    ->where('end_date', '>=', $eventStart);
                })->orWhere(function ($q) use ($eventStart, $eventEnd) {
                    $q->where('start_date', '<=', $eventEnd)
                    ->where('end_date', '>=', $eventEnd);
                })->orWhere(function ($q) use ($eventStart, $eventEnd) {
                    $q->where('start_date', '>=', $eventStart)
                    ->where('end_date', '<=', $eventEnd);
                });
            })->get();

        foreach ($unavailablePeriods as $period) {
            $conflicts[] = [
                'type' => 'unavailable',
                'details' => 'Unavailable: ' . $period->reason . ' (' . Carbon::parse($period->start_date)->format('M d, Y H:i') . ' - ' . Carbon::parse($period->end_date)->format('M d, Y H:i') . ')'
            ];
        }

        return $conflicts;
    }

    public function updatedSearchTerm()
    {
        $this->loadAvailablePhotographers();
    }

    public function updatedSpecializationFilter()
    {
        $this->loadAvailablePhotographers();
    }

    public function togglePhotographer($photographerId)
    {
        if (in_array($photographerId, $this->selectedPhotographers)) {
            $this->selectedPhotographers = array_diff($this->selectedPhotographers, [$photographerId]);
        } else {
            $this->selectedPhotographers[] = $photographerId;
        }
    }

    public function toggleAvailabilityDetails($photographerId)
    {
        if (isset($this->showAvailabilityDetails[$photographerId])) {
            unset($this->showAvailabilityDetails[$photographerId]);
        } else {
            $this->showAvailabilityDetails[$photographerId] = true;
        }
    }

    public function clearAssignment() {
        try {
            $query = DB::table('booking_photographer')->where('booking_id', $this->booking->id);
            //code...
            if($query->exists())
            {
                $query->delete();
                session()->flash('success', 'All photographers unassigned successfully');
            }else
            {
                session()->flash('error', 'There is no photographer to assigned');
            }
        } catch (\Exception $e) {
            //throw $th;
            session()->flash('error', 'Failed to clear assignments: '.$e->getMessage());
            report($e); // Log the error
        }
    }

    public function assignPhotographers()
    {
        $this->validate();

        try {
            // Remove existing assignments
            BookingPhotographer::where('booking_id', $this->booking->id)->delete();

            // Add new assignments
            foreach ($this->selectedPhotographers as $photographerId) {
                BookingPhotographer::create([
                    'booking_id' => $this->booking->id,
                    'photographer_id' => $photographerId,
                    'assigned_by' => Auth::id()
                ]);
            }

            session()->flash('success', 'Photographers assigned successfully!');
            $this->showModal = false;
            $this->dispatch('photographer-assigned');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to assign photographers. Please try again.');
        }
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->loadAvailablePhotographers();
        $this->loadCurrentAssignments();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['searchTerm', 'specializationFilter', 'showAvailabilityDetails']);
    }

    public function render()
    {
        return view('livewire.photographer-assignment');
    }
}
