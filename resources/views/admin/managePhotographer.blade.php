@extends('layout.app')
@yield('title', 'Manage Photographer')

@section('content')
<div class="container">
    <h3 class="mb-4">Manage Photographer</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <livewire:photographer-assignment />

</div>

@endsection