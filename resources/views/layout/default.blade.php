<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document')</title>
    @vite('resources\css\app.css')
    @livewireStyles
</head>

<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="container">
            <div class="nav-container">
                <div class="logo">Calystra Studio</div>
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ url('/') }}#services">Services</a></li>
                    <li><a href="###">About</a></li>
                    <li><a href="###">Contact</a></li>
                </ul>
                <div class="mobile-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <a href="#booking" class="cta-button">Book Now</a>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    @yield('content')
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Calystra Studio</h3>
                    <p>Professional photography services in Malaysia, specializing in weddings, corporate events, and family portraits.</p>
                </div>
                <div class="footer-section">
                    <h3>Services</h3>
                    <p><a href="#services">Wedding Photography</a></p>
                    <p><a href="#services">Corporate Events</a></p>
                    <p><a href="#services">Family Portraits</a></p>
                    <p><a href="#services">Event Photography</a></p>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p>Email: hello@calystrastudio.com</p>
                    <p>Phone: +60 12-345-6789</p>
                    <p>Location: Kuala Lumpur, Malaysia</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <p><a href="#booking">Book Now</a></p>
                    <p><a href="#about">About Us</a></p>
                    <p><a href="#contact">Contact</a></p>
                    <p><a href="#gallery">Portfolio</a></p>
                    <p><a href="#gallery">FAQ</a></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Calystra Studio. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @vite('resources\js\app.js')
    @livewireScripts
</body>

</html>