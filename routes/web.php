<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use Livewire\Volt\Volt;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\User\Dashboard as UserDashboard;

Route::view('/', 'welcome')->name('welcome'); // Public welcome page

// Role-based redirection after login
Route::get('/dashboard', function () {
    return match (Auth::user()->role) {
        'admin' => redirect('/admin/dashboard'),
        'user' => redirect('/user/dashboard'),
        default => abort(403),
    };
})->middleware('auth');

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');


// Admin-only routes
Route::middleware(['auth', RoleMiddleware::class . ':admin',])
    ->group(function () {
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


 Route::get('/', function () {
    return view('home');
 })->name('home');

Route::get('/booking', function () {
    return view('booking');
})->name('booking');

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

Route::get('/admin/upload_image/create', [ImageController::class, 'create'])->name('images.create');
Route::post('/admin/upload_image/index', [ImageController::class, 'store'])->name('images.store');

Route::get('/admin/upload_image', [ImageController::class, 'index'])->name('images.index');
Route::delete('/admin/upload_image/{id}', [ImageController::class, 'destroy'])->name('image.destroy');
// });require __DIR__.'/auth.php';

//show wedding image to user
Route::get('/wedding', [ImageController::class, 'showWeddingGallery'])->name('wedding');

require __DIR__ . '/auth.php';
