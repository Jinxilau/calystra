<?php

namespace App\Livewire;

use App\Models\AddOn;
use App\Models\Booking;
use App\Models\BookingAddOn;
use Livewire\WithFileUploads;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BookingForm extends Component
{
    use WithFileUploads;

    // Payment Details

    public $payment_type = 'deposit'; // Default payment type
    public $depositAmount = 200.00; // Default deposit amount
    // public $paymentMethod = 'bank_transfer';
    public $receipt;

    // Customer Details
    #[Validate('required|string|max:100')]
    public $customer_name = '';
    #[Validate('required|string|max:20')]
    public $customer_phone = '';


    // Event Details
    #[Validate('required|string|in:wedding,corporate,family,portrait,event,other')]
    public $event_type;
    #[Validate('required|date|after:today')]
    public $event_date;
    #[Validate('required|date_format:H:i')]
    public $start_time;
    #[Validate('nullable|string|max:255')]
    public $event_location = '';
    #[Validate('required|string|max:100')]
    public $event_name = '';
    #[Validate('nullable|integer|min:0|max:1000')]
    public $guest_count = 0;
    #[Validate('required|string|in:pending,paid,partial')]
    public $deposit_status = 'pending';
    #[Validate('nullable|string|max:1000')]
    public $notes = '';

    // Add-ons
    public $selectedAddOns = [];
    public $availableAddOns;
    public $addonQuantities = []; // To track quantities of selected add-ons

    public $categories = [
        'time_extension' => 'Time Extensions',
        'prints' => 'Prints & Albums',
        'digital' => 'Digital Services',
        'equipment' => 'Equipment & Props',
        'styling' => 'Styling & Makeup',
        'location' => 'Location Services'
    ];

    // Form state
    public $currentStep = 1;
    public $totalSteps = 4;
    public $showSuccessMessage = false;

    public function mount()
    { // Initialize component 
        if (Auth::check()) {
            $user = Auth::user();
            $this->customer_name = $user->name;
            $this->customer_phone = $user->phone ?? ''; // Optional, if phone is available
        }
        $this->loadAvailableAddOns();
        // $this->loadSelectedAddOns();
    }

    public function nextStep()
    {
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    private function validateCurrentStep()
    {
        switch ($this->currentStep) {
        case 1:
            $this->validate([
                'event_name' => 'required|string|max:100',
                'event_type' => 'required|string',
                'event_date' => 'required|date|after:today',
                'start_time' => 'required|date_format:H:i',
                'event_location' => 'nullable|string|max:1000',
                'guest_count' => 'nullable|integer|min:0|max:1000',
            ]);
            break;
        case 2:
            $this->validate([
                'customer_name' => 'required|string|max:255',
                // 'contact_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
            ]);
            break;
        case 3: // TODO: Add validation for add-ons
            // $this->validate([
            //     'customer_name' => 'required|string|max:255',
            //     // 'contact_email' => 'required|email|max:255',
            //     'customer_phone' => 'required|string|max:20',
            // ]);
            break;
        case 4:
            $this->validate([
                'notes' => 'nullable|string|max:1000',
                'paymentMethod' => 'required|in:bank_transfer,online_banking,cash',
                'receipt' => 'required|image|max:2048', // 2MB max
                'paymentReference' => 'required|string|max:100',
                'customerNotes' => 'nullable|string|max:500'
            ]);
            break;
        }
    }

    protected $messages = [
        'receipt.required' => 'Please upload your payment receipt.',
        'receipt.image' => 'Receipt must be an image file.',
        'receipt.max' => 'Receipt file size must not exceed 2MB.',
        // 'paymentReference.required' => 'Please enter the payment reference number.'
    ];

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

    public function loadAvailableAddOns() // Load available add-ons from the database
    {
        $this->availableAddOns = AddOn::active()->orderBy('name')->get();
    }

    public function loadSelectedAddOns() // TODO: Load selected add-ons for the booking if it exists
    {
        // if (!$this->bookingId) {
        //     $bookingAddOns = BookingAddOn::where('booking_id', $this->bookingId)->get();

        //     foreach ($bookingAddOns as $bookingAddOn) {
        //         $this->selectedAddOns[$bookingAddOn->add_on_id] = [
        //             'quantity' => $bookingAddOn->quantity,
        //             'notes' => $bookingAddOn->notes
        //         ];
        //     }
        // }
    }

    public function toggleAddon($addonId)
    {
        if (in_array($addonId, $this->selectedAddOns)) {
            // Remove addon
            $this->selectedAddOns = array_diff($this->selectedAddOns, [$addonId]);
            unset($this->addonQuantities[$addonId]);
        } else {
            // Add addon
            $this->selectedAddOns[] = $addonId;
            $this->addonQuantities[$addonId] = 1;
        }
    }

    public function incrementQuantity($addonId)
    {
        $this->addonQuantities[$addonId] = ($this->addonQuantities[$addonId] ?? 0) + 1;
        // $this->calculateTotal();
    }

    public function decrementQuantity($addonId)
    {
        if($this->addonQuantities[$addonId] > 1) {
            $this->addonQuantities[$addonId]--;
            // $this->calculateTotal();
        }
    }

    public function updateQuantity($addonId, $quantity)
    {
        if ($quantity <= 0) {
            $this->toggleAddon($addonId);
            return;
        }
        
        $this->addonQuantities[$addonId] = max(1, $quantity);
    }

    public function submitForm()
    {
        $validatedData = $this->validate();
        DB::beginTransaction();

        try {

            // Create the booking with validated data
            $booking = Booking::create([
                'user_id' => Auth::id(), // Associate with logged-in user if available
                'event_type' => $this->event_type,
                'event_date' => $this->event_date,
                'start_time' => $this->start_time,
                'event_location' => $this->event_location,
                'event_name' => $this->event_name,
                'guest_count' => $this->guest_count,
                'notes' => $this->notes,
                'status' => 'pending', // Default booking status
            ]);

            // Create payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $this->depositAmount,
                'payment_type' => 'deposit',
                // 'payment_method' => $this->paymentMethod,
                'receipt_path' => $this->receipt->store('receipts', 'public'), // Store receipt and get path
                'status' => 'pending_verification',
            ]);

            // Add new booking & add-ons
            foreach ($this->selectedAddOns as $addOnId) {
                $addOn = $this->availableAddOns->find($addOnId);
                if ($addOn) {
                    BookingAddOn::create([
                        'booking_id' => $booking->id,
                        'add_on_id' => $addOnId,
                        'quantity' => $this->addonQuantities[$addOnId] ?? 1, // Default to 1 if not set
                    ]);
                }
            }

            User::where('id', Auth::id())->update([
                'fullname' => $this->customer_name,
                'phone' => $this->customer_phone,
            ]);

            // Reset form fields after successful submission
            $this->resetForm();
            DB::commit();
            // Flash success message
            session()->flash('success', 'Booking request submitted successfully! We will contact you shortly.');

            $this->showSuccessMessage = true;
            $this->currentStep = $this->totalSteps + 1; // Move to success step

            // Dispatch browser event
            $this->dispatch('booking-created');
        } catch (\Exception $e) {
            DB::rollback();
            // Handle any errors during booking creation
            session()->flash('error', 'Something went wrong. Please try again.');
        }
    }

    public function resetForm()
    {
        $this->reset();

        $this->mount(); // Reinitialize component state
        // Keep deposit_status as pending
        $this->deposit_status = 'pending';
        $this->currentStep = 1; // Reset to first step
        $this->showSuccessMessage = false; // Reset success message state
    }

    public function render()
    {
        return view('livewire.booking-form', [
            'eventTypes' => $this->eventTypes, // Use computed property for event types
        ]);
    }
}
