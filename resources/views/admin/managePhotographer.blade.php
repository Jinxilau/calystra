@extends('layout.app')
{{-- @yield('title', 'Manage Photographer') --}}

@section('content')
<div class="container">
    <h3 class="mb-1">Photographer Availability</h3>


    {{-- Photographer Availability Section --}}
    @livewire('photographer-availability')

</div>
@endsection