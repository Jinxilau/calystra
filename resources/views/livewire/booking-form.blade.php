<div>
    <div class="booking-form-container">
        <form wire:submit.prevent="submit" class="booking-form">
            @if (session()->has('success'))
                <div class="text-green-600" style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
            @endif
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" wire:model="name" required>
                @error('name')
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" wire:model="email" required>
                @error('email') 
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" wire:model="phone" required>
                @error('phone') 
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="date">Preferred Date</label>
                <input type="date" id="date" wire:model="date" required>
                @error('date') 
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="time">Preferred Time</label>
                <input type="time" id="time" wire:model="time" required>
                @error('time') 
                    <span style="color: red;">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="submit-button">Submit Booking</button>
        </form>
    </div>
    <div class="booking-confirmation" wire:loading wire:target="submit">
        <p>Processing your booking...</p>
    </div>

</div>