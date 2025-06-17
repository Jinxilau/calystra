@extends('layout.app')

@section('content')

<div class="row justify-content-center">
    <h3>Manage Booking</h3>
</div>


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
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>
                    <input type="checkbox" id="select-booking" name="select-booking[]" value="{{ $booking->id }}">
                </td>
                <td>{{$booking->id}}</td>
                <td>{{$booking->user->fullname?? 'Unknown User'}}</td>
                <td>{{$booking->event_type}}</td>
                <td>{{$booking->event_date}}</td>
                <td>{{$booking->start_time}}</td>
                <td>{{$booking->event_location}}</td>
                <td>{{$booking->guest_count}}</td>
                <td>
                    @if($booking->status == 'approved')
                    <span class="badge bg-success">Approved</span>
                    @elseif($booking->status == 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                    @else
                    <span class="badge bg-danger">Denied</span>
                    @endif
                </td>
                <td>
                    <form action="{{ route('booking.update', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                            <option value="approved" {{$booking->status == 'approved' ? 'selected' : ''}}>Approved</option>
                            <option value="pending" {{$booking->status == 'pending' ? 'selected' : ''}}>Pending</option>
                            <option value="denied" {{$booking->status == 'denied' ? 'selected' : ''}}>Denied</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</form>
@endsection