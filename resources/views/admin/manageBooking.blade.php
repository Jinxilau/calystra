@extends('layout.app')

@section('content')

<div class="row justify-content-center">
    <h3>Manage Booking</h3>
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
                </tr>
            </thead>
            <tbody>
               
                    @foreach($bookings as $booking)
                    <tr>
                        <td>{{$booking->id}}</td>
                        <td>{{$booking->user->fullname}}</td>
                        <td>{{$booking->event_type}}</td>
                        <td>{{$booking->event_date}}</td>
                        <td>{{$booking->start_time}}</td>
                        <td>{{$booking->event_location}}</td>
                        <td>{{$booking->guest_count}}</td>

                    </tr>
                    @endforeach
                
                
            </tbody>
        </table>
@endsection 
