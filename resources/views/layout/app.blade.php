<!DOCTYPE html>
<?php
use Illuminate\Support\Facades\Auth;
?>

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
        #sidebar{ 
            overflow: hidden;
            min-width: 137px;
            position: fixed;
            start: 0; 
            bottom: 0; 
            height: 93.5vh; 
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px 5px 10px 15px;
            display: flex;
            flex-direction: column;
            /* position: relative; */
        }

        #content {
            margin-left: 16.67%; 
            padding-top: 65px;
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            /* Lightens the background */
            transition: background-color 0.3s ease-in-out;
            /* Smooth transition */
        }

        nav-link.active {
            color: white;
        }

        .admin-sidebar {
            border-right: 1px solid #dee2e6;
            overflow: 137px;
        }
        .admin-sidebar .nav-link {
            color: #495057;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }
        .admin-sidebar .nav-link:hover {
            color: #c3c3c3;
            background-color: rgba(13, 110, 253, 0.05);
        }
        .admin-sidebar .nav-link.active {
            color: #ffffff;
            background-color: rgba(13, 110, 253, 0.1);
            border-left-color: #0d6efd;
            font-weight: 500;
        }
        .admin-sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }

        #logout:hover {
            background-image: linear-gradient(rgb(27, 0, 0) 0%, rgb(110, 1, 1) 100%);
            color: #fff;
        }

        @media(max-width: 992px) {
            #sidebar {
                position: relative;
                padding: 93px 20px 10px 20px;
                width: 100%;
                display: block;
                height: auto; 
            }

            #content {
                margin-left: 0px; 
                margin-top: 10px;
                padding-top: 0px;
            }
            #block {
                display: none;
            }
            .admin-sidebar {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    {{-- Top Nav --}}
    <nav class="navbar bg-body-tertiary" style="position: fixed; top: 0; width: 100%; z-index: 1000; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
        <div class="container-fluid">
            <a class="navbar-brand">Calystra Studio</a>
            <span class="me-3 text-secondary">Welcome back, {{ Auth::user()->name}}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger ms-3">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container-fluid min-vh-100" id="idk">
        <div class="row min-vh-100">
            <!-- Sidebar -->
            <div class="col-12 col-lg-2 bg-light bg-dark text-white" id="sidebar">
                <h4 class="pb-3">Menu</h4>
                <div class="d-flex align-items-center">
                    @if(auth()->check())
                    <a class="btn border border-light text-light" style="position: relative; z-index: 1050;" href="{{ route('profile') }}">
                        {{ auth()->user()->name }}
                    </a>
                    @endif
                </div>
                @if(auth()->check())
                <span>{{auth()->user()->email}}</span>
                @endif
                <hr>

                <div class="bg-dark text-white p-3 hover-bg-light" id="block"></div>

                <ul class="nav flex-column admin-sidebar">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center py-3 {{ (request()->is('admin/manageBooking') || request()->is('admin/manageBooking/*')) ? 'active' : '' }}" href="{{ route('manageBooking') }}">
                            <i class="bi bi-calendar-check me-3"></i>
                            <span class="fw-medium">Manage Bookings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center py-3 {{ request()->is('admin/upload_image') ? 'active' : '' }}" href="{{ route('images.index') }}">
                            <i class="bi bi-images me-3"></i>
                            <span class="fw-medium">Manage Images</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center py-3 {{ request()->is('admin/managePhotographer') ? 'active' : '' }}" href="{{ route('managePhotographer') }}">
                            <i class="bi bi-person-video3 me-3"></i>
                            <span class="fw-medium">Photographer Availability</span>
                        </a>
                    </li>
                </ul>
                <form method="POST" action="{{ route('logout') }}" class="mt-auto pb-2">
                    @csrf
                    <button class="dropdown-item text-danger fw-bold text-center border border-danger py-2" type="submit" id="logout">Logout</button>
                </form>
            </div>

            <!-- Main Content Section -->
            <div class="col-12 col-lg-10" id="content">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    @livewireScripts
</body>

</html>