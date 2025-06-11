<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/booking', function () {
    return view('booking');
})->name('booking');

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


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Route::middleware(['auth'])->group(function () {
//     // Admin routes
//     Route::middleware(['can:admin'])->group(function () {
        Route::get('/admin/upload_image', [ImageController::class, 'create'])->name('images.create');
        Route::post('admin/upload_image', [ImageController::class, 'store'])->name('images.store');
    // });

    // User routes
    // Route::get('/images', [ImageController::class, 'index'])->name('images.index');
// });


require __DIR__.'/auth.php';
