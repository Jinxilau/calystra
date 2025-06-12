<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document')</title>
    @vite('resources\css\home.css')
    @yield('assets')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
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
                <a href="{{ route('booking') }}" class="cta-button">Book Now</a>

                @auth
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" 
                                type="button" 
                                id="userDropdown" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false"
                                style="position: relative; z-index: 1050;">
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" 
                            aria-labelledby="userDropdown"
                            style="position: absolute; z-index: 1051;">
                            <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('settings.profile') }}">
                                    Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                        @endif
                    </div>
                @endauth
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    @livewireScripts
</body>

</html>