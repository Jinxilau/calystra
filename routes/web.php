<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\User\Dashboard as UserDashboard;

// Route::view('/', 'welcome')->name('welcome'); // Public welcome page

// Role-based redirection after login
Route::get('/dashboard', function () {
    return match (Auth::user()->role) {
        'admin' => redirect('/admin/dashboard'),
        'user' => redirect('/user/dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('dashboard');

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

Route::get('/login', function () {
    return view('/login');
})->name('login');

// Admin-only routes
Route::middleware(['auth', RoleMiddleware::class . ':admin',])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class);
    // Add more admin routes here
});

// Normal user routes
Route::middleware(['auth', RoleMiddleware::class . ':user',])->group(function () {
    Route::get('/user/dashboard', UserDashboard::class);
    // Add more user routes here
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->middleware('auth');

Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');


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

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

require __DIR__ . '/auth.php';
