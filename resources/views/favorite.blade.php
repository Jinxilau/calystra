@extends('layout.default')

@section('title', 'favorite')

@section('assets')
@vite('resources/css/image.css')
@endsection

@section('content')

<div class="container pt-3" style="margin-top: 80px;">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

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

    <h3>My Favorite Images</h3>
    <div class="row row-cols-4 row-cols-md-4 g-4">
        @forelse($favorites as $favorite)
        <div class="col">
            <div class="card h-80 shadow-sm">
                <img src="{{ asset('storage/images/' . $favorite->image->filename) }}" class="card-img-top" alt="Favorite" style="height: 380px; object-fit: cover">
                <div class="card-body d-flex justify-content-center">
                    <form action="{{ route('favorites.delete', $favorite->id) }}" method="POST">
                        @csrf
                        <div class="shadow-lg hover-shadow">
                            <button type="submit" class="bg-transparent p-0 border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="grey" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p>No favorites yet.</p>
        @endforelse
    </div>
</div>
@endsection