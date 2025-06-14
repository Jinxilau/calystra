<div class="container mb-3">
    {{-- Progress Indicator --}}
    @if(!$showSuccessMessage)
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 d-flex justify-content-center">
                <ul class="list-unstyled p-0 m-0 position-relative stepper-vertical d-inline-flex justify-content-center">
                    @for($i = 1; $i <= $totalSteps; $i++)
                    <li class="position-relative pb-1 {{ $currentStep >= $i ? 'active' : '' }} d-inline-flex">
                        {{-- Stepper Head --}}
                        <div class="d-flex flex-column align-items-center justify-content-center align-items-center position-relative text-center">
                            <span class="stepper-head-icon d-flex align-items-center justify-content-center fw-bold text-white rounded-circle {{ $currentStep >= $i ? 'bg-primary' : 'bg-secondary' }}">
                                {{ $i }}
                            </span>
                            <div class="stepper-content py-0">
                                <p class="text-muted small mb-0">
                                    @if($i == 1) Event Details
                                    @elseif($i == 2) Contact Information
                                    @else Package & Review
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

<div class="text-center mb-4">
    <p class="text-muted small">
        Step {{ $currentStep }} of {{ $totalSteps }}
    </p>
</div>
@endif
    {{-- Booking Form --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg booking-form-container">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-camera me-2"></i> Book Your Photography Session
                    </h3>
                </div>
                <div class="card-body p-4">
                    <!-- Success/Error Messages -->
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form wire:submit="submitForm">
                        <!-- Customer Information Section -->
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-user me-2"></i>Customer Information
                            </h5>
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

                        <!-- Event Details Section -->
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
                                    <input type="text" class="form-control @error('event_name') is-invalid @enderror" id="event_name" wire:model="event_name" placeholder="e.g., Sarah & John's Wedding">
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
                                    <label for="event_time" class="form-label custom-time">Event Time <span class="text-danger">*</span></label>
                                    <input type="time" 
                                           class="form-control @error('event_time') is-invalid @enderror" 
                                           id="event_time"
                                           wire:model="event_time">
                                    @error('event_time')
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

                        <!-- Additional Information Section -->
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2"><i class="fas fa-info-circle me-2"></i>Additional Information</h5>
                            {{-- <div class="mb-3">
                                <label for="deposit_status" class="form-label">Deposit Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('deposit_status') is-invalid @enderror" id="deposit_status" wire:model="deposit_status">
                                    <option value="pending">Pending</option>
                                    <option value="partial">Partial Payment</option>
                                    <option value="paid">Fully Paid</option>
                                </select>
                                @error('deposit_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            
                            <div class="mb-3">
                                <label for="notes" class="col-form-label">Special Notes</label> <span class="form-text text-secondary">(Optional)</span>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" wire:model="notes" rows="4" placeholder="Any special requirements, preferences, or additional information..."></textarea>
                                @error('notes')
                                <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Share any specific requirements or preferences for your event.</div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg text-white" wire:loading.attr="disabled" wire:target="submitForm">
                                <span wire:loading.remove wire:target="submitForm" class="submit-button"></i>Submit Booking Request</span>
                                <span wire:loading wire:target="submitForm"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light">
                    <div class="row text-center">
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                These Information are Secure & Confidential
                            </small>
                        </div>
                        {{-- <div class="col-md-4">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Quick Response Time
                            </small>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">
                                <i class="fas fa-star me-1"></i>
                                Professional Service
                            </small> --}}
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>