@extends('layout.default')

@section('title', 'Calystra Studio - Professional Photography in Malaysia')

@section('assets')
@vite('resources\css\home.css')
@endsection

@section('content')
<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container">
        <div class="hero-content fade-in">
            <h1>Capture Your Perfect Moments</h1>
            <p>Professional photography services in Malaysia. From weddings to corporate events, we make every moment unforgettable with our streamlined booking system.</p>
            <div class="hero-buttons">
                <a href="{{ route('booking') }}" class="btn-primary">Start Booking</a>
                <a href="#services" class="btn-secondary">View Services</a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="services">
    <div class="container">
        <div class="section-title fade-in">
            <h2>Our Photography Services</h2>
            <p>Professional photography tailored to your needs with easy online booking</p>
        </div>
        <div class="services-grid">
            <a href="{{ route('wedding') }}" class="link">
                <div class="service-card fade-in">
                    <img src="{{asset('images/wedding.png')}}" class="service-image" alt="">
                    <div class="service-icon">💒</div>
                    <h3>Wedding Photography</h3>
                    <p>Capture your special day with our expert wedding photographers. From intimate ceremonies to grand celebrations.</p>
                    <ul class="service-features">
                        <li>Pre-wedding consultation</li>
                        <li>Full-day coverage</li>
                        <li>Professional editing</li>
                        <li>Online gallery delivery</li>
                        <li>Customizable packages</li>
                    </ul>
                </div>
            </a>
            <a href="{{ route('corporate') }}" class="link">
                <div class="service-card fade-in">
                    <img src="{{asset('images/event.png')}}" class="service-image" alt="">
                    <div class="service-icon">🏢</div>
                    <h3>Corporate Events</h3>
                    <p>Professional event photography for corporate functions, conferences, and business gatherings.</p>
                    <ul class="service-features">
                        <li>Event planning support</li>
                        <li>Multiple photographers</li>
                        <li>Quick turnaround</li>
                        <li>High-resolution images</li>
                        <li>Commercial licensing</li>
                    </ul>
                </div>
            </a>
            <div class="service-card fade-in">
                <div class="service-icon">👠</div>
                <img src="{{asset('images/fashion.png')}}" class="service-image" alt="">
                <h3>Fashion & Style</h3>
                <p>Stylish fashion and personal style photoshoots available in-studio or at curated outdoor locations.</p>
                <ul class="service-features">
                    <li>Studio or on-location fashion shoots</li>
                    <li>Wardrobe styling and fashion props included</li>
                    <li>Multiple outfit changes encouraged</li>
                    <li>High-end professional retouching</li>
                    <li>Portfolio and print packages available</li>
                </ul>
            </div>
            <div class="service-card fade-in">
                <img src="{{asset('images/convo.png')}}" class="service-image" alt="">
                <div class="service-icon">👨‍🎓</div>
                <h3>Convocation</h3>
                <p>Celebrate your academic achievement with professional convocation photoshoots in-studio or at meaningful locations.</p>
                <ul class="service-features">
                    <li>Studio or on-location convocation shoots</li>
                    <li>Graduation robes and props provided (optional)</li>
                    <li>Family and group photo options</li>
                    <li>Professional editing and retouching</li>
                    <li>Print and digital packages available</li>
                </ul>
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
            <a href="#booking" class="btn-primary">Start Your Booking</a>
        </div>
    </div>
</section>
@endsection