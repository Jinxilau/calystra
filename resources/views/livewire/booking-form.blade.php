<div>
    <div class="booking-form-container">
        <form wire:submit.prevent="submitForm" class="booking-form">
            @if (session()->has('success'))
                <div class="alert alert-success" style="margin-bottom: 2rem;">
                    Booking submitted successfully! We'll contact you soon.
                </div>
            @endif
            <div class="mb-3 form-group">
                <label class="form-label" for="name">Your Name</label>
                <input type="text" id="name" wire:model="name" class="form-control" placeholder="Enter your full name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" wire:model="email" class="form-control" placeholder="your.email@example.com">
                @error('email') 
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" id="phone" wire:model="phone" class="form-control" placeholder="(555) 123-4567">
                @error('phone') 
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="date" class="form-label">Preferred Date</label>
                <input type="date" id="date" wire:model="date" class="form-control">
                @error('date') 
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="time" class="form-label">Preferred Time</label>
                <input type="time" id="time" wire:model="time" class="form-control">
                @error('time') 
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="submit-button btn btn-primary">Submit Booking</button>
            <div class="booking-confirmation" wire:loading wire:target="submitForm">
                <p>Processing your booking...</p>
            </div>
        </form>
    </div>
</div>