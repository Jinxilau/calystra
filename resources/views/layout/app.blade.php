<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'My App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<style>
    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        /* Lightens the background */
        transition: background-color 0.3s ease-in-out;
        /* Smooth transition */
    }
</style>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand">Calystra Studio</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger ms-3">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-light p-3 bg-dark text-white d-flex flex-column" style="height: 100vh;">
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
                        <a class="nav-link {{ request()->is('admin/manageBooking') ? 'active' : '' }}" href="{{ route('manageBooking') }}">
                            <h5>Manage Booking</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/upload_image') ? 'active' : '' }}" href="{{ route('images.index') }}">
                            <h5>Manage Image</h5>
                        </a>
                    </li>
                </ul>
                <form method="POST" action="{{ route('logout') }}" class="mt-auto pb-5">
                    @csrf
                    <button class="dropdown-item text-danger" type="submit">Logout</button>
                </form>
            </div>

            <!-- Content Section -->
            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </div>

</body>

</html>