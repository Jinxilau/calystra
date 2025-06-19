<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document')</title>
    @vite('resources\css\home.css')
    @yield('assets')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @livewireStyles
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
    <nav id="navbar" class="" style="z-index: 1051; max-height: 90px; padding: min(24px, 1.5vw) 0px">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list h2 text-white" id="hambur"></i>
            </button>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images\icon\icon_white.png') }}" alt="Logo" id="logo-icon" class="logo-icon" style="object-fit: cover; overflow: visible; width: 130px; height: 30px; position: relative; z-index: 1050; top: 5px;">
                </a>
                <div class="logo d-none d-md-block" id="logo" style="font-size: clamp(12px, 2.5vw, 28px)">Calystra Studio</div>
            </div>
            <ul class="nav-links pe-md-3 pe-lg-0 pe-0 mb-0" style="gap: 2vw">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('home') }}#services">Services</a></li>
                <li><a href="{{ route('aboutUs')}}">About</a></li>
                <li><a href="{{route('contact')}}">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center justify-content-end gap-2">
                <a href="{{ route('booking') }}" class="cta-button px-2 py-2 px-md-3 py-md-2" style="width:max-content; white-space: nowrap">Book Now</a>

                @auth
                <div class="dropdown">
                    <button class="btn dropdown-toggle border rounded-pill text-light border-light" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="position: relative; z-index: 1050;">
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="position: absolute; z-index: 1051;">
                        <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        {{-- <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li> --}}
                        <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('favorites.index') }}">My favourites</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <div class="auth-buttons d-md-flex gap-1" style="width: 14vw; min-width: 80px;">
                    <a href="{{ route('login') }}" id="login" class="btn btn-outline-light" wire:navigate style="width: 100%">Login</a>
                    <a href="{{ route('register') }}" id="register" class="btn btn-light" wire:navigate style="width: 100%">Register</a>
                </div>
                @endauth
            </div>
        </div>
    </nav>
    <div class="collapse" id="navbarToggleExternalContent" style="z-index: 1050; width:100%; position: fixed; top: 74px;">
        <div class="p-4 bg-dark text-light">
            <ul class="nav-links pe-md-3 pe-lg-0 pe-0 mb-0" style="display: block;">
                <li class="h5"><a href="{{ route('home') }}">Home</a></li>
                <li class="h5"><a href="{{ route('home') }}#services">Services</a></li>
                <li class="h5"><a href="{{ route('aboutUs')}}">About</a></li>
                <li class="h5"><a href="{{route('contact')}}">Contact</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    @yield('content')
    
    <!-- Footer -->
    <footer class="mt-auto">
        <div class="container">
            <div class="footer-content flex-grow-1 container">
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
                    <p>Phone: +60 17-255 1905</p>
                    <p>Location: Kuala Lumpur, Malaysia</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <p><a href="#booking">Book Now</a></p>
                    <p><a href="{{route('aboutUs')}}">About Us</a></p>
                    <p><a href="{{route('contact')}}">Contact</a></p>
                    <p><a href="{{ route('home')}}#services">Portfolio</a></p>
                    {{-- <p><a href="#">FAQ</a></p> --}}
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Calystra Studio. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        const logo_icon = document.getElementById('logo-icon');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                logo_icon.src = "{{ asset('images/icon/icon_black.png') }}"; // Change logo link on scroll
            } else {
                logo_icon.src = "{{ asset('images/icon/icon_white.png')}}"; // Change logo link on scroll
            }
        });
    </script>

    @vite('resources\js\app.js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    @livewireScripts
</body>

</html>