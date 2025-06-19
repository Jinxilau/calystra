@extends('layout.default')

@section('title', 'Calystra Studio - Professional Photography in Malaysia')

@section('assets')
{{-- @vite('resources\css\home.css') --}}
@endsection

@section('content')
<!-- Hero Section -->
<section id="home" class="hero py-3 py-md-0">
    <div class="container d-md-flex align-items-center justify-content-between">
        <div class="hero-content fade-in mb-2 mb-md-0">
            <h1>Capture Your Perfect Moments</h1>
            <p>Professional photography services in Malaysia. From weddings to corporate events, we make every moment unforgettable with our streamlined booking system.</p>
            <div class="hero-buttons">
                <a href="{{ route('booking') }}" class="btn-primary text-dark">Start Booking</a>
                <a href="#services" class="btn-secondary">View Services</a>
            </div>
        </div>
        <div id="carouselExampleFade" class="carousel slide carousel-fade">
            <div class="carousel-inner" style="width: 100%; height: auto; max-width: 600px; min-width: 200px; border: 5px solid #fff; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
                <div class="carousel-item active">
                    <img src="{{asset('images/wedding3.png')}}" class="d-block w-100" alt="Calystra Studio - Professional Photography">
                </div>
                <div class="carousel-item">
                    <img src="{{asset('images/wedding5.png')}}" class="d-block w-100" alt="Calystra Studio - Professional Photography">
                </div>
                <div class="carousel-item">
                    <img src="{{asset('images/wedding6.png')}}" class="d-block w-100" alt="Calystra Studio - Professional Photography">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
            {{-- <img src="{{asset('images/wedding3.png')}}" alt="Calystra Studio - Professional Photography" style=""> --}}
    </div>
</section>

<!-- Services Section -->
<!-- Services Section -->
<section id="services" class="services">
    <div class="container">
        <h2>Our Photography Services</h2>
        <p>Professional photography tailored to your needs with easy online booking</p>

        <div class="row">
            <div class="col-md-6 mb-4">
                <a href="{{ route('wedding') }}" class="link">
                    <div class="service-card fade-in">
                        <img src="{{asset('images/wedding.png')}}" class="service-image" alt="">
                        <div class="service-icon">💒</div>
                        <h3>Wedding Photography</h3>
                        <p>Capture your special day with our expert wedding photographers...</p>
                        <ul class="service-features">
                            <li>Pre-wedding consultation</li>
                            <li>Full-day coverage</li>
                            <li>Professional editing</li>
                            <li>Online gallery delivery</li>
                            <li>Customizable packages</li>
                        </ul>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-4">
                <a href="{{ route('corporate') }}" class="link">
                    <div class="service-card fade-in">
                        <img src="{{asset('images/event.png')}}" class="service-image" alt="">
                        <div class="service-icon">🏢</div>
                        <h3>Corporate Events</h3>
                        <p>Professional event photography for corporate functions...</p>
                        <ul class="service-features">
                            <li>Event planning support</li>
                            <li>Multiple photographers</li>
                            <li>Quick turnaround</li>
                            <li>High-resolution images</li>
                            <li>Commercial licensing</li>
                        </ul>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-4">
                <a href="{{ route('fashion') }}" class="link">
                    <div class="service-card fade-in">
                        <div class="service-icon">👠</div>
                        <img src="{{asset('images/fashion.png')}}" class="service-image" alt="">
                        <h3>Fashion & Style</h3>
                        <p>Stylish fashion and personal style photoshoots...</p>
                        <ul class="service-features">
                            <li>Studio or on-location shoots</li>
                            <li>Wardrobe styling</li>
                            <li>Outfit changes encouraged</li>
                            <li>High-end retouching</li>
                            <li>Portfolio packages</li>
                        </ul>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-4">
                <a href="{{ route('convo') }}" class="link">
                    <div class="service-card fade-in">
                        <img src="{{asset('images/convo.png')}}" class="service-image" alt="">
                        <div class="service-icon">👨‍🎓</div>
                        <h3>Convocation</h3>
                        <p>Celebrate your academic achievement with professional shoots...</p>
                        <ul class="service-features">
                            <li>Studio or on-location</li>
                            <li>Robes and props optional</li>
                            <li>Group photo options</li>
                            <li>Retouching included</li>
                            <li>Digital and print packages</li>
                        </ul>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Why Choose Our Booking System?</h2>
            <p>Streamlined, professional, and designed for your convenience</p>
        </div>
        <div class="features-grid">
            <div class="feature-card fade-in">
                <div class="feature-icon">📅</div>
                <h3>Easy Scheduling</h3>
                <p>Book your photography session online with real-time availability and instant confirmation.</p>
            </div>
            <div class="feature-card fade-in">
                <div class="feature-icon">💳</div>
                <h3>Secure Payments</h3>
                <p>Safe and secure online payment processing with multiple payment options available.</p>
            </div>
            <div class="feature-card fade-in">
                <div class="feature-icon">📱</div>
                <h3>Mobile Friendly</h3>
                <p>Access your bookings, communicate with photographers, and manage appointments from any device.</p>
            </div>
            <div class="feature-card fade-in">
                <div class="feature-icon">🔄</div>
                <h3>Flexible Rescheduling</h3>
                <p>Need to change your appointment? Reschedule easily through our user-friendly system.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content fade-in">
            <h2>Ready to Book Your Session?</h2>
            <p>Join hundreds of satisfied clients who trust Calystra Studio for their special moments</p>
            <a href="{{route('booking') }}" class="btn-primary">Start Your Booking</a>
        </div>
    </div>
</section>
@endsection