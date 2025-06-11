@extends('layout.default')

@section('title', 'Wedding')

@section('assets')
@vite('resources/css/image.css')
@endsection

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Wedding Gallery</h1>

    <div class="row row-cols-1 row-cols-md-4 g-4">
        <div class="col">
            <div class="card h-80 shadow-sm">
                    <img src="{{ asset('images/wedding/wedding1.png') }}" class="card-img-top"  alt="Wedding Ceremony" style="height: 380px; object-fit: cover">
                <div class="card-body d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" fill="red" class="bi bi-bookmark-heart-fill" viewBox="0 0 16 16">
                        <path d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                    </svg>
                </div>
            </div>  
        </div>

        <div class="col">
            <div class="card h-80 shadow-sm">
                    <img src="{{ asset('images/wedding/wedding1.png') }}" class="card-img-top"  alt="Wedding Ceremony" style="height: 380px; object-fit: cover">
                <div class="card-body d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" fill="red" class="bi bi-bookmark-heart-fill" viewBox="0 0 16 16">
                        <path d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                    </svg>
                </div>
            </div>  
        </div>

        <div class="col">
            <div class="card h-80 shadow-sm">
                    <img src="{{ asset('images/wedding/wedding1.png') }}" class="card-img-top"  alt="Wedding Ceremony" style="height: 380px; object-fit: cover">
                <div class="card-body d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" fill="red" class="bi bi-bookmark-heart-fill" viewBox="0 0 16 16">
                        <path d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                    </svg>
                </div>
            </div>  
        </div>

        <div class="col">
            <div class="card h-80 shadow-sm">
                    <img src="{{ asset('images/wedding/wedding1.png') }}" class="card-img-top"  alt="Wedding Ceremony" style="height: 380px; object-fit: cover">
                <div class="card-body d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" fill="red" class="bi bi-bookmark-heart-fill" viewBox="0 0 16 16">
                        <path d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                    </svg>
                </div>
            </div>  
        </div>

        <div class="col">
            <div class="card h-80 shadow-sm">
                    <img src="{{ asset('images/wedding/wedding1.png') }}" class="card-img-top"  alt="Wedding Ceremony" style="height: 380px; object-fit: cover">
                <div class="card-body d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" fill="red" class="bi bi-bookmark-heart-fill" viewBox="0 0 16 16">
                        <path d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                    </svg>
                </div>
            </div>  
        </div>

        <div class="col">
            <div class="card h-80 shadow-sm">
                    <img src="{{ asset('images/wedding/wedding1.png') }}" class="card-img-top"  alt="Wedding Ceremony" style="height: 380px; object-fit: cover">
                <div class="card-body d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="30" height="30" fill="red" class="bi bi-bookmark-heart-fill" viewBox="0 0 16 16">
                        <path d="M2 15.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2zM8 4.41c1.387-1.425 4.854 1.07 0 4.277C3.146 5.48 6.613 2.986 8 4.412z" />
                    </svg>
                </div>
            </div>  
        </div>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/wedding7.jpg') }}" class="card-img-top" alt="First Dance" style="height: 250px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">First Dance</h5>
                    <p class="card-text flex-grow-1">The magical first dance as husband and wife, surrounded by the warm glow of candlelight and love.</p>
                    <button class="btn btn-primary mt-auto" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ asset('images/wedding7.jpg') }}">
                        View Full Size
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Image Preview -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Wedding Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>
@endsection