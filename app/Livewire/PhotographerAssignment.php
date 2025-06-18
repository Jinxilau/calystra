<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\BookingPhotographer;
use App\Models\Photographer;
use App\Models\PhotographerAvailability;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PhotographerAssignment extends Component
{
    public $booking;
    public $selectedPhotographer = '';
    public $availablePhotographers = [];
    public $assignedPhotographers = [];
    public $showAssignModal = false;
    public $searchTerm = '';
    public $filterSpecialization = '';
    public $showAvailabilityDetails = false;
    public $photographerAvailability = [];

    protected $rules = [
        'selectedPhotographer' => 'required|exists:photographers,id',
    ];

    protected $messages = [
        'selectedPhotographer.required' => 'Please select a photographer to assign.',
        'selectedPhotographer.exists' => 'Selected photographer is not valid.',
    ];

    public function mount($bookingId)
    {
        $this->booking = Booking::with(['user', 'assignedPhotographers.photographer'])->findOrFail($bookingId);
        $this->loadAssignedPhotographers();
        $this->loadAvailablePhotographers();
    }

    public function loadAssignedPhotographers()
    {
        $this->assignedPhotographers = $this->booking->assignedPhotographers()
            ->with('photographer')
            ->get()
            ->toArray();
    }

    public function loadAvailablePhotographers()
    {
        $eventDate = Carbon::parse($this->booking->event_date);
        $startTime = Carbon::parse($this->booking->event_date . ' ' . $this->booking->start_time);

        // Get photographers who are not already assigned to this booking
        $alreadyAssignedIds = collect($this->assignedPhotographers)->pluck('photographer_id');

        $query = Photographer::where('is_active', true)
            ->whereNotIn('id', $alreadyAssignedIds);

        // Apply search filter
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Apply specialization filter
        if (!empty($this->filterSpecialization)) {
            $query->where('specialization', 'like', '%' . $this->filterSpecialization . '%');
        }

        $photographers = $query->get();

        // Check availability for each photographer
        $this->availablePhotographers = $photographers->map(function ($photographer) use ($eventDate, $startTime) {
            $isAvailable = $this->checkPhotographerAvailability($photographer->id, $eventDate, $startTime);

            return [
                'id' => $photographer->id,
                'name' => $photographer->name,
                'email' => $photographer->email,
                'phone' => $photographer->phone,
                'specialization' => $photographer->specialization,
                'bio' => $photographer->bio,
                'profile_photo' => $photographer->profile_photo,
                'is_available' => $isAvailable,
                'availability_status' => $isAvailable ? 'Available' : 'Not Available'
            ];
        })->sortBy([
            ['is_available', 'desc'], // Available photographers first
            ['name', 'asc'] // Then sort by name
        ])->values()->toArray();
    }

    public function checkPhotographerAvailability($photographerId, $eventDate, $startTime)
    {
        // Check if photographer has any conflicting bookings
        $conflictingBookings = BookingPhotographer::where('photographer_id', $photographerId)
            ->whereHas('booking', function ($query) use ($eventDate) {
                $query->where('event_date', $eventDate->format('Y-m-d'))
                    ->where('status', '!=', 'denied');
            })
            ->exists();

        if ($conflictingBookings) {
            return false;
        }

        // Check photographer availability schedule
        $unavailableSlots = PhotographerAvailability::where('photographer_id', $photographerId)
            ->where(function ($query) use ($eventDate, $startTime) {
                $query->where(function ($q) use ($eventDate, $startTime) {
                    // Check if event time overlaps with unavailable slots
                    $q->whereDate('start_date', '<=', $eventDate->format('Y-m-d'))
                        ->whereDate('end_date', '>=', $eventDate->format('Y-m-d'));
                });
            })
            ->exists();

        return !$unavailableSlots;
    }

    public function showAssignPhotographerModal()
    {
        $this->showAssignModal = true;
        $this->selectedPhotographer = '';
    }

    public function closeAssignModal()
    {
        $this->showAssignModal = false;
        $this->selectedPhotographer = '';
        $this->resetValidation();
    }

    public function assignPhotographer()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Check if photographer is still available
            $photographer = Photographer::findOrFail($this->selectedPhotographer);
            $eventDate = Carbon::parse($this->booking->event_date);
            $startTime = Carbon::parse($this->booking->event_date . ' ' . $this->booking->start_time);

            if (!$this->checkPhotographerAvailability($photographer->id, $eventDate, $startTime)) {
                $this->addError('selectedPhotographer', 'Selected photographer is no longer available for this date and time.');
                return;
            }

            // Create the assignment
            BookingPhotographer::create([
                'booking_id' => $this->booking->id,
                'photographer_id' => $this->selectedPhotographer,
                'assigned_by' => Auth::id(),
            ]);

            DB::commit();

            $this->loadAssignedPhotographers();
            $this->loadAvailablePhotographers();
            $this->closeAssignModal();

            session()->flash('success', 'Photographer assigned successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            $this->addError('selectedPhotographer', 'Failed to assign photographer. Please try again.');
        }
    }

    public function removePhotographer($assignmentId)
    {
        try {
            BookingPhotographer::findOrFail($assignmentId)->delete();

            $this->loadAssignedPhotographers();
            $this->loadAvailablePhotographers();

            session()->flash('success', 'Photographer removed successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to remove photographer assignment.');
        }
    }

    public function updatedSearchTerm()
    {
        $this->loadAvailablePhotographers();
    }

    public function updatedFilterSpecialization()
    {
        $this->loadAvailablePhotographers();
    }

    public function showPhotographerAvailability($photographerId)
    {
        $this->photographerAvailability = PhotographerAvailability::where('photographer_id', $photographerId)
            ->orderBy('start_date')
            ->get()
            ->toArray();

        $this->showAvailabilityDetails = true;
    }

    public function closeAvailabilityModal()
    {
        $this->showAvailabilityDetails = false;
        $this->photographerAvailability = [];
    }


    public function render() // This method is responsible for rendering the view associated with this Livewire component
    {
        return view('livewire.photographer-assignment');
    }
}
