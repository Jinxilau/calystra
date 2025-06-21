@extends('layout.app')

@section('content')

<!-- Sucess Notification Message -->
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Failed Notification Message -->
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert" id="failed-alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Script -->
<script>
    // Automatically fade out after 3 seconds
    setTimeout(function() {
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('failed-alert');

        if (successAlert) {
            let bsAlert = new bootstrap.Alert(successAlert);
            bsAlert.close();
        }

        if (errorAlert) {
            let bsAlert = new bootstrap.Alert(errorAlert);
            bsAlert.close();
        }
    }, 3000);
</script>


<div class="container-fluid">
    <h3>Manage Booking</h3>



    <form method="GET" action="{{ route('manageBooking') }}">
        <div class="flex-grow-3 mb-5">
            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search anything..."
                class="form-control" onkeydown="if(event.key === 'Enter') this.form.submit();">
        </div>
    </form>


    <div class="d-flex justify-content-end">
        <!-- Date Sorting -->
        <form method="GET" action="{{ route('manageBooking') }}" class="mb-3 pe-3">
            <label for="sort" class="form-label">Filtered By Date</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="">-- Select Date --</option>
                <option value="nearest" {{ request('sort') == 'nearest' ? 'selected' : '' }}>Nearest to Farthest</option>
                <option value="farthest" {{ request('sort') == 'farthest' ? 'selected' : '' }}>Farthest to Nearest</option>
            </select>
        </form>

        <!-- Event Sorting -->
        <form method="GET" action="{{ route('manageBooking') }}" class="mb-3">
            <label for="type" class="form-label">Filtered By Event</label>
            <select name="type" id="type" onchange="this.form.submit()">
                <option value="">-- All Types --</option>
                @foreach($events as $event)
                <option value="{{ $event }}" {{ $filterType == $event ? 'selected' : '' }}>
                    {{ ucfirst($event) }}
                </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Delete Booking -->
    <form action="{{ route('booking.destroy')}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?');">
        @csrf
        @method('DELETE')
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Booking ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Event Type</th>
                    <th scope="col">Event Date</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">Location</th>
                    <th scope="col">Number of guest</th>
                    <th scope="col">Add On</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td>
                        <input type="checkbox" name="selected-booking[]" value="{{ $booking->id }}">
                    </td>
    </form>
    <td>{{$booking->id}}</td>
    <td>{{$booking->user->fullname?? 'Unknown User'}}</td>
    <td>{{$booking->event_type}}</td>
    <td>{{$booking->event_date}}</td>
    <td>{{$booking->start_time}}</td>
    <td>{{$booking->event_location}}</td>
    <td>{{$booking->guest_count}}</td>
    <td>
        <a data-bs-toggle="collapse"
            href="#addonsRow{{ $booking->id }}"
            role="button"
            aria-expanded="false"
            aria-controls="addonsRow{{ $booking->id }}">
            View Add-ons
        </a>
    </td>
    <td>
        @if($booking->status == 'approved')
        <span class="badge bg-success">Approved</span>
        @elseif($booking->status == 'pending')
        <span class="badge bg-warning text-dark">Pending</span>
        @else
        <span class="badge bg-danger">Denied</span>
        @endif
    </td>
    <td class="d-flex flex-column" style="max-width: 200px">
        <!-- Update Booking -->
        <form action="{{ route('booking.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')
            <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                <option value="approved" {{$booking->status == 'approved' ? 'selected' : ''}}>Approved</option>
                <option value="pending" {{$booking->status == 'pending' ? 'selected' : ''}}>Pending</option>
                <option value="denied" {{$booking->status == 'denied' ? 'selected' : ''}}>Denied</option>
            </select>
        </form>
        <livewire:photographer-assignment :booking="$booking->id"/>
    </td>
    </tr>

    <!-- Collapsible Row for add on -->
    <tr class="collapse" id="addonsRow{{ $booking->id }}">
        <td colspan="12">
            @if($booking->bookingAddOns->isEmpty())
            <div class="text-muted">No add-ons selected for this booking.</div>
            @else
            <ul class="list-group">
                @foreach($booking->bookingAddOns as $bookingAddon)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $bookingAddon->addOn->name }}
                    {{$bookingAddon->quantity}}
                    <small class="text-muted">{{ $bookingAddon->addOn->description }}</small>
                </li>
                @endforeach
            </ul>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
    </table>
</div>
@endsection