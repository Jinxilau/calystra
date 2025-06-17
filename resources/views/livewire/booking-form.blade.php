<div class="container mb-3">
    {{-- Success Message --}}
    @if($showSuccessMessage)
    <div class="text-center py-5">
        <div class="mx-auto mb-4 bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
            <i class="fas fa-check text-success fs-3"></i>
        </div>
        <h2 class="h3 fw-bold mb-3">Booking Submitted Successfully!</h2>
        <p class="text-muted mb-4">Thank you for choosing Calystra Studio. We'll contact you within 24 hours to confirm your booking.</p>
        <button wire:click="resetForm" class="btn btn-primary px-4">Make Another Booking</button>
    </div>
    @else
    {{-- Progress Indicator --}}
    <div class="container mb-2">
        <div class="row justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <ul class="steper-step list-unstyled p-0 m-0 position-relative stepper-vertical d-inline-flex justify-content-center">
                    @for($i = 1; $i <= $totalSteps; $i++)
                    <li class="stepper position-relative pb-1 {{ $currentStep >= $i ? 'actived' : '' }} {{ $i < $currentStep ? 'completed' : '' }} d-inline-flex">
                        {{-- Stepper Head --}}
                        <div class="d-flex flex-column align-items-center justify-content-center align-items-center position-relative text-center" style="width: 12vw; min-width: 70px;">
                            {{-- Stepper Icon --}}
                            <span class="stepper-head-icon d-flex align-items-center justify-content-center fw-bold rounded-circle">
                                {{ $i }}
                            </span>
                            <div class="stepper-content py-0">
                                <p class="text-muted small mb-0">
                                    @if($i == 1) Event Details
                                    @elseif($i == 2) Contact Information
                                    @elseif($i == 3) Add-ons Selection
                                    @else Review & Deposit Payment
                                    @endif
                                </p>
                            </div>
                        </div>
                        {{-- Stepper Line --}}
                        @if($i < $totalSteps)
                        <span class="stepper-head-line"></span>
                        @endif
                    </li>
                    @endfor
                </ul>
            </div>
        </div>
    </div>
    
    {{-- Current Step Indicator --}}
    <div class="text-center mt-4 mt-lg-0 mb-1 d-none d-md-block">
        <p class="text-muted small">
            Step {{ $currentStep }} of {{ $totalSteps }}
        </p>
    </div>
    @endif

    @if(!$showSuccessMessage)
    {{-- Booking Form --}}
    <div class="row justify-content-center mt-5 mt-md-0">
        <div class="col-lg-10">
            <div class="card shadow-lg booking-form-container">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0"><i class="fas fa-camera me-2"></i> @if($currentStep == 1)Event Details @elseif($currentStep == 2) Customer Information @elseif($currentStep == 3) Add-ons Selection @elseif($currentStep == 4)Review & Deposit Payment @endif</h3>
                </div>
                <div class="card-body p-4">
                    <form wire:submit="nextStep">
                        {{-- Step 1: Event Details --}}
                        @if($currentStep == 1)
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-calendar-alt me-2"></i>Event Details
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="event_type" class="form-label">Event Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('event_type') is-invalid @enderror" id="event_type" wire:model="event_type">
                                        <option value="">Select event type...</option>
                                        {{-- Using the argument passed --}}
                                        @foreach($eventTypes as $key => $label) 
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('event_type')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="event_name" class="form-label">Event Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('event_name') is-invalid @enderror" id="event_name" wire:model="event_name" placeholder="e.g., Sarah & John's Wedding" value="{{ old('event_name') }}">
                                    @error('event_name')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="event_date" class="form-label custom-date">Event Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('event_date') is-invalid @enderror" id="event_date" wire:model="event_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    @error('event_date')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="start_time" class="form-label custom-time">Event Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time" wire:model="start_time">
                                    @error('start_time')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="event_location" class="col-form-label custom-location">Event Location</label> <span class="form-text text-secondary">(Optional)</span>
                                    <input type="text" class="form-control @error('event_location') is-invalid @enderror" id="event_location" wire:model="event_location" placeholder="Venue name, address, or location">
                                    @error('event_location')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="guest_count" class="col-form-label custom-count">Guest Count</label> <span class="form-text text-secondary">(Optional)</span>
                                    <input type="number" class="form-control @error('guest_count') is-invalid @enderror" id="guest_count" wire:model="guest_count" min="1" max="1000" placeholder="1" value="1">
                                    @error('guest_count')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Step 2: Contact Information --}}
                        @if($currentStep == 2)
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2"><i class="fas fa-user me-2"></i>Customer Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label custom-name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" wire:model="customer_name" placeholder="Enter your full name" value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                {{-- <div class="col-md-6 mb-3">
                                    <label for="customer_email" class="form-label custom-email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('customer_email') is-invalid @enderror" 
                                           id="customer_email"
                                           wire:model="customer_email" 
                                           placeholder="your.email@example.com">
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                
                                <div class="col-md-6 mb-3">
                                    <label for="customer_phone" class="form-label custom-phone">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" wire:model="customer_phone" placeholder="+60 12-345-6789">
                                    @error('customer_phone')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($currentStep == 3)
                        <!-- Step 3: Add-ons Selection -->
                        <div class="mb-4">
                            <h3 class="h4 fw-semibold text-dark my-0">Enhance Your Photography Experience</h3>
                            <p class="text-muted mb-4">Select additional services to make your photoshoot even more special.</p>
                            
                            @foreach($availableAddOns->groupBy('type') as $type => $addOns)
                            <div class="card mb-2 overflow-hidden">
                                <div class="card-header bg-gradient bg-primary text-white py-1">
                                    <h4 class="h5 mb-0">{{ $categories[$type] ?? ucfirst(str_replace('_', ' ', $type)) }}</h4>
                                </div>
                                
                                <div class="card-body p-2 pt-4">
                                    <div class="row g-3">
                                        @foreach($addOns as $addon)
                                        <div class="col-12 col-md-6 col-lg-4 mt-0">
                                            <div class="border rounded px-3 {{ in_array($addon->id, $selectedAddOns) ? 'border-primary bg-primary bg-opacity-10' : 'border-light-subtle' }}">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="addon-{{ $addon->id }}" wire:click="toggleAddon({{ $addon->id }})" {{ in_array($addon->id, $selectedAddOns) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-semibold" for="addon-{{ $addon->id }}">{{ $addon->name }}</label>
                                                    
                                                    @if($addon->description)
                                                    <p class="text-muted small m-0">{{ $addon->description }}</p>
                                                    @endif

                                                    @if($addon->price)
                                                    <span class="text-primary fw-bold" style="margin: ">RM {{ number_format($addon->price, 2) }}</span>
                                                    @endif
                                                    
                                                </div>
                                                @if(in_array($addon->id, $selectedAddOns))
                                                @if(!is_null($addon->quantity))
                                                <div class="d-flex align-items-center justify-content-center my-2">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <!-- Quantity controls (commented out as in original) -->
                                                        <button class="btn btn-sm btn-outline-primary rounded-circle p-0" wire:click="decrementQuantity({{ $addon->id }})" style="width: 24px; height: 24px;">
                                                            <i class="bi bi-dash"></i>
                                                        </button>
                                                        
                                                        <input type="number" readonly wire:model="addonQuantities.{{ $addon->id }}" wire:change="updateQuantity({{ $addon->id }}, $event.target.value)" class="form-control form-control-sm text-center" style="width: 60px;">
                                                        
                                                        <button class="btn btn-sm btn-outline-primary rounded-circle p-0" wire:click="incrementQuantity({{ $addon->id }})" style="width: 24px; height: 24px;">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @endif
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        
                        {{-- Step 4: Review & Deposit Payment --}}
                        @if($currentStep == 4)
                        <div class="space-y-6">
                            <!-- Additional Information Section -->
                            <div class="mb-4">
                                <h5 class="text-primary border-bottom pb-2"><i class="fas fa-info-circle me-2"></i>Additional Information</h5>
                                <div class="mb-3">
                                    <label for="notes" class="col-form-label">Special Notes</label> <span class="form-text text-secondary">(Optional)</span>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" wire:model="notes" rows="4" placeholder="Any special requirements, preferences, or additional information..."></textarea>
                                    @error('notes')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Share any specific requirements or preferences for your event.</div>
                                </div>
                            </div>

                            {{-- Booking Summary --}}
                            <div class="card bg-light p-3 mb-4 rounded">
                                <h3 class="h5 fw-bold text-dark mb-3">Booking Summary</h3>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-2 border-0">
                                        <span class="text-muted">Name:</span>
                                        <span class="fw-medium">{{ $this->customer_name }}</span>
                                    </div>
                                    <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-2 border-0">
                                        <span class="text-muted">Phone Number:</span>
                                        <span class="fw-medium">{{ $this->customer_phone }}</span>
                                    </div>
                                    <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-2 border-0">
                                        <span class="text-muted">Event:</span>
                                        <span class="fw-medium">{{ $this->eventTypes[$event_type] ?? 'Not selected' }}</span>
                                    </div>
                                    <div class="list-group-item bg-transparent d-flex justify-content-between px-0 py-2 border-0">
                                        <span class="text-muted">Date & Time:</span>
                                        <span class="fw-medium">{{ $event_date }} at {{ $start_time }}</span>
                                    </div>
                                </div>
                                <div class="border-t pt-6">
                                    <h6 class="text-gray-900 mb-4 mt-2">{{ (sizeof($selectedAddOns) > 0) ? 'You have selected the following add-ons:' : 'No add-ons selected.' }}</h6>
                                    @if(sizeof($selectedAddOns) > 0)
                                    @foreach($selectedAddOns as $addon)
                                    @php
                                        $addOn = $availableAddOns->find($addon)
                                    @endphp
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                                        <div>
                                            <span class="font-medium">{{ $addOn->name }}</span>
                                            @if(($addonQuantities[$addon] ?? 1) > 1)
                                            <span class="text-sm text-gray-600 ml-2">x{{ $addonQuantities[$addon] }}</span>
                                            @endif
                                        </div>
                                        <span class="font-medium">RM {{ number_format($addOn->price, 2) }}</span>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- Deposit Payment Section --}}
                            <div class="mt-4 p-3 bg-primary bg-opacity-10 rounded border border-primary">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 text-primary">Deposit Required</span>
                                    <span class="h4 fw-bold text-primary">RM {{ number_format($depositAmount, 2) }}</span>
                                </div>
                            </div>
                            <!-- Payment Method Selection -->
                            {{-- <div class="mb-4">
                                <label class="form-label mb-2">Payment Method</label>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="paymentMethod" value="bank_transfer" id="bankTransfer">
                                        <label class="form-check-label" for="bankTransfer">Bank Transfer</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="paymentMethod" value="online_banking" id="onlineBanking">
                                        <label class="form-check-label" for="onlineBanking">Online Banking</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="paymentMethod" value="cash" id="cashDeposit">
                                        <label class="form-check-label" for="cashDeposit">Cash Deposit</label>
                                    </div>
                                </div>
                                @error('paymentMethod') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <!-- Receipt Upload -->
                            <div class="mb-4">
                                <label for="receipt" class="form-label">Upload Payment Receipt <span class="text-danger">*</span></label>
                                <div class="d-flex justify-content-center w-100">
                                    <label for="receipt" class="d-flex flex-column align-items-center justify-content-center w-100 rounded-3 bg-light hover-bg-light p-4" style="height: 8rem;">
                                        @if($receipt)
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <i class="bi bi-check-circle-fill text-success fs-3 mb-2"></i>
                                            <p class="text-success small fw-medium mb-1">{{ $receipt->getClientOriginalName() }}</p>
                                            <p class="text-muted small">Click to change file</p>
                                        </div>
                                        @else
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <i class="bi bi-cloud-arrow-up text-muted fs-3 mb-2"></i>
                                            <p class="text-muted small mb-1"><span class="fw-semibold">Click to upload</span> receipt</p>
                                            <p class="text-muted xsmall">PNG, JPG or JPEG (MAX. 2MB)</p>
                                        </div>
                                        @endif
                                        <input id="receipt" type="file" wire:model="receipt" class="d-none" accept="image/*">
                                    </label>
                                </div>
                                @error('receipt')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                
                                <div wire:loading wire:target="receipt" class="mt-2">
                                    <div class="d-flex align-items-center">
                                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                                        <span class="text-primary small">Uploading receipt...</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Important Notes -->
                            <div class="mb-4 p-3 bg-warning bg-opacity-10 border border-warning rounded">
                                <h3 class="h6 fw-medium text-warning mb-2">Important Notes:</h3>
                                <ul class=" small text-warning-emphasis mb-0">
                                    <li class="mb-1">Please ensure the payment amount matches exactly: RM {{ number_format($depositAmount, 2) }}</li>
                                    <li class="mb-1">Your booking will be confirmed within 24 hours after payment verification</li>
                                    <li class="mb-1">Keep your payment receipt for records</li>
                                    <li>Contact us at +60 12-345 6789 if you need assistance</li>
                                </ul>
                            </div>

                            <!-- Contact Information -->
                            <div class="mt-5 text-center">
                                <p class="text-muted">Need help? Contact us:</p>
                                <div class="d-flex justify-content-center gap-3 mt-2">
                                    <span class="text-dark"><i class="bi bi-telephone me-1"></i> +60 12-345 6789</span>
                                    <span class="text-dark"><i class="bi bi-envelope me-1"></i> calystrastudio@gmail.com</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        {{-- Navigation Buttons --}}
                        <div class="d-flex justify-content-around mt-4 pt-3 border-top">
                            @if($currentStep > 1)
                                <button type="button" wire:click="previousStep" class="btn btn-outline-secondary px-4">Previous</button>
                                <div></div>
                            @endif

                            @if($currentStep < $totalSteps)
                                <div></div>
                                <button type="button" wire:click="nextStep" class="btn btn-primary px-4">Next Step</button>
                            @else
                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg text-white" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="nextStep" class="submit-button"></i>Submit Booking Request</span>
                                    <span wire:loading wire:target="nextStep">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                            @endif
                        </div>
                    </form>
                    <!-- Error Messages -->
                    @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                </div>
                
                <div class="card-footer bg-light">
                    <div class="row text-center">
                        <div>
                            <small class="text-muted"><i class="fas fa-shield-alt me-1"></i>These Information are Secure & Confidential</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>