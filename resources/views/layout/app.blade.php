<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 bg-light" style="height: 100vh;">
            <h4 class="p-3">Menu</h4>
            <ul class="nav flex-column px-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/manageBooking') ? 'active' : '' }}" href="{{ route('managebooking') }}">Manage Booking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/upload_image') ? 'active' : '' }}" href="{{ route('manageimage') }}">Manage Image</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/manageUser') ? 'active' : '' }}" href="{{ route('manageuser') }}">Manage User</a>
                </li>
            </ul>
        </div>

        <!-- Content Section -->
        <div class="col-md-9 p-4">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>
