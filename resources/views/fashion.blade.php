@extends('layout.default')

@section('title', 'Wedding')

@section('assets')
@vite('resources/css/image.css')
@endsection

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Wedding Gallery</h1>

    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach($fashionImages as $image)
        <div class="col">
            <div class="card h-80 shadow-sm">
                <img src="{{ asset('storage/images/'. $image->filename) }}" class="card-img-top" alt="Wedding Ceremony" style="height: 380px; object-fit: cover">
                <div class="card-body d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-bookmark-heart-fill" viewBox="0 0 16 16">
                        <path d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                    </svg>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection