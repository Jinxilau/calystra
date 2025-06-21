<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My App')</title>
    @yield('assets')
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @livewireStyles
    <style>
        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            /* Lightens the background */
            transition: background-color 0.3s ease-in-out;
            /* Smooth transition */
        }

        nav-link.active {
            color: white;
        }
    </style>
</head>

<body>
    {{-- Top Nav --}}
    <nav class="navbar bg-body-tertiary" style="position: fixed; top: 0; width: 100%; z-index: 1000; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <div class="container-fluid">
            <a class="navbar-brand">Calystra Studio</a>
            <span class="me-3 text-secondary">Welcome back, Admin</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger ms-3">Logout</button>
            </form>
        </div>
    </nav>

    {{-- Side Nav --}}
    <div class="container-fluid min-vh-100 ">
        <div class="row min-vh-100">
            <!-- Sidebar -->
            <div class="col-md-2 bg-light p-3 bg-dark text-white d-flex flex-column position-md-fixed" style="position: fixed; start: 0; bottom: 0; height: 93.5vh; box-shadow: 5px 0 10px rgba(0, 0, 0, 0.1);">
                <h4 class="pb-3">Menu</h4>
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-circle me-3" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg>
                    @if(auth()->check())
                    <p class="pt-3">{{auth()->user()->name}}
                    <p>
                </div>
                <span>{{auth()->user()->email}}</span>
                @endif
                <hr>
                <div class="bg-dark text-white p-3 hover-bg-light">

                </div>
                <ul class="nav flex-column px-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manageBooking') ? 'active' : '' }}" href="{{ route('manageBooking') }}">
                            <h5>Manage Booking</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/upload_image') ? 'active' : '' }}" href="{{ route('images.index') }}">
                            <h5>Manage Image</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/managePhotographer') ? 'active' : '' }}" href="{{ route('managePhotographer') }}">
                            <h5>Manage Photographer Availability</h5>
                        </a>
                    </li>
                </ul>
                <form method="POST" action="{{ route('logout') }}" class="mt-auto pb-2">
                    @csrf
                    <button class="dropdown-item text-danger" type="submit">Logout</button>
                </form>
            </div>

            <!-- Main Content Section -->
            <div class="col-md-10" style="margin-left: 16.67%; padding-top: 65px;">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    @livewireScripts
</body>

</html>