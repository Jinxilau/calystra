@extends('layout.app')

@section('content')
    <h3>My Favorite Images</h3>
    <div class="row">
        @forelse($favorites as $favorite)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset('storage/images/' . $favorite->image->filename) }}" class="card-img-top" alt="Favorite">
                </div>
            </div>
        @empty
            <p>No favorites yet.</p>
        @endforelse
    </div>
@endsection
