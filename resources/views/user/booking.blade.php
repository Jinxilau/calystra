@extends('layout.default')

@section('title', 'Book Your Photography Session')
@section('assets')
    @vite('resources\css\bookingform.css')
@endsection
@section('content')
    {{-- Booking Section --}}
    <section id="booking" class="booking-section row justify-content-center">
        <div class="container text-center" style="text-align: center;">
            <h2 class="section-title">Book Your Photography Session</h2>
            <p class="lead" style="font-size: clamp(8px, 1vw + 0.5rem, 25px)">Fill out the form below to schedule your photography session with us.</p>
        </div>
    </section>

    {{-- Booking Form --}}
    @livewire('booking-form')
    @vite('resources/js/app.js')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireScripts
    {{-- <section id="testimonials" class="testimonials-section">
        <div class="container">
            <h2 class="section-title">What Our Clients Say</h2>
            <div class="testimonial-card fade-in">
                <p>"Calystra Studio captured our wedding day perfectly! The photos are stunning and the team was so professional."</p>
                <p class="client-name">- Sarah & John</p>
            </div>
            <div class="testimonial-card fade-in">
                <p>"We hired Calystra for our corporate event and they exceeded our expectations. Highly recommend!"</p>
                <p class="client-name">- Mark, CEO of TechCorp</p>
            </div>
        </div>
    </section>
    <section id="faq" class="faq-section">
        <div class="container">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <div class="faq-item fade-in">
                <h3>How do I book a session?</h3>
                <p>You can book a session by filling out the booking form on this page. We will get back to you to confirm your booking.</p>
            </div>
            <div class="faq-item fade-in">
                <h3>What is your cancellation policy?</h3>
                <p>We require at least 48 hours notice for cancellations. Please contact us as soon as possible if you need to cancel or reschedule.</p>
            </div>
        </div>
    </section>
    <section id="contact" class="contact-section">
        <div class="container">
            <h2 class="section-title">Contact Us</h2>
            <p>If you have any questions or need assistance, feel free to reach out to us.</p>
            <p>Email:<a href="mailto:jinxilau9@gmail.com">jinxilau9@gmail.com</a>
        </div>
    </section> --}}
@endsection