@extends('layout.default')

@section('title', 'Wedding')

@section('assets')
@vite('resources/css/image.css')
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="container pt-3">
    <h1 class="text-center mb-4">Corporate Event Gallery</h1>

    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach($convoImages as $image)
        <div class="col">
            <div class="card h-80 shadow-sm">
                <img src="{{ asset('storage/images/'. $image->filename) }}" class="card-img-top" alt="Wedding Ceremony" style="height: 380px; object-fit: cover">
                <div class="card-body d-flex justify-content-center">
                    <form action="{{ route('favorites.add', $image->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="border: none; background: none; padding: 0;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red" class="bi bi-bookmark-heart-fill" viewBox="0 0 16 16">
                                <path d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    // Automatically fade out after 3 seconds
    setTimeout(function() {
        let alert = document.getElementById('success-alert');
        if (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close(); // Triggers Bootstrap's dismiss animation
        }
    }, 3000); // 3 seconds
</script>
@endsection