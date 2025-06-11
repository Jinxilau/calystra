<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use Livewire\Volt\Volt;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\User\Dashboard as UserDashboard;

Route::view('/', 'welcome');

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');


// Role-based redirection after login
Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    return $role === 'admin'
        ? redirect('/admin/dashboard')
        : redirect('/user/dashboard');
})->middleware('auth');

// Admin-only routes
Route::middleware([
    'auth',
    RoleMiddleware::class . ':admin',
])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class);
    // Add more admin routes here
});

// Normal user routes
Route::middleware([
    'auth',
    RoleMiddleware::class . ':user',
])->group(function () {
    Route::get('/user/dashboard', UserDashboard::class);
    // Add more user routes here
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->middleware('auth');

// Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

// Route::view('profile', 'profile')->middleware(['auth'])->name('profile');


// // Route::get('/', function () {
// //     return view('home');
// // })->name('home');

// Route::get('/booking', function () {
//     return view('booking');
// })->name('booking');

// Route::get('/wedding', function () {
//     return view('wedding');
// })->name('wedding');

// Route::get('/upload_image', function () {
//     return view('upload_image');
// })->name('upload_image');

Route::get('/wedding', function () {
    return view('wedding');
})->name('wedding');

Route::get('/admin/manageBooking', function () {
    return view('admin.manageBooking');
})->name('managebooking');

Route::get('/admin/manage_image', function () {
    return view('admin.upload_image');
})->name('manageimage');

Route::get('/admin/manageUser', function () {
    return view('admin.manageUser');
})->name('manageuser');


// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::get('/admin/upload_image', [ImageController::class, 'create'])->name('images.create');
Route::post('admin/upload_image', [ImageController::class, 'store'])->name('images.store');
// });

require __DIR__ . '/auth.php';
