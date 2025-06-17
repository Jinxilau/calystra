<?php

use App\Http\Controllers\BookingController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use Livewire\Volt\Volt;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\User\Dashboard as UserDashboard;
use App\Http\Controllers\FavoriteController;

// Route::view('/', 'welcome')->name('welcome'); // Public welcome page
Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/login', function () {
    return view('resources\views\livewire\pages\auth\login.blade.php');
})->name('login');

// Role-based redirection after login
Route::get('/dashboard', function () {
    return match (Auth::user()->role) {
        'admin' => redirect('/admin/manageBooking'),
        'user' => redirect('/'),
        default => abort(403),
    };
})->middleware('auth')->name('dashboard');


// Route::get('/', function () {
//     return redirect('/dashboard');
// })->middleware('auth');

Route::get('/user/booking', function () {
    return view('user.booking');
})->middleware('auth')->name('booking');

Route::post('/logout', function () {
    Auth::logout(); 
    return redirect('/');
})->middleware('auth')->name('logout');

// Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

// Route::get('/settings/profile', function () {
//     return view('livewire.settings.profile');
// })->middleware('auth')->name('settings.profile');

// Admin-only routes
Route::middleware(['auth', RoleMiddleware::class . ':admin',])->group(function () {
    Route::get('/admin/manageBooking', [BookingController::class, 'index'])->name('manageBooking');
    Route::put('/admin/manageBooking/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/admin/manageBooking', [BookingController::class, 'destroy'])->name('booking.destroy');

    //ManageImage
    //Upload Image
    Route::get('/admin/upload_image/create', [ImageController::class, 'create'])->name('images.create');
    //Store Image
    Route::post('/admin/upload_image', [ImageController::class, 'store'])->name('images.store');
    //Show Image
    Route::get('/admin/upload_image', [ImageController::class, 'index'])->name('images.index');
    //Delete Image
    Route::delete('/admin/upload_image/{id}', [ImageController::class, 'destroy'])->name('image.destroy');
    // Add more admin routes here
});

// Normal user routes
Route::middleware(['auth', RoleMiddleware::class . ':user',])->group(function () {
    // Route::get('/user/dashboard', UserDashboard::class)->name('user.dashboard');
    //show wedding image to user
    Route::get('/wedding', [ImageController::class, 'showWeddingGallery'])->name('wedding');
    //Show event image to user
    Route::get('/corporate', [ImageController::class, 'showEventGallery'])->name('corporate');
    //Show fashion image to user
    Route::get('/fashion', [ImageController::class, 'showFashionGallery'])->name('fashion');
    //Show convo image to user
    Route::get('/convo', [ImageController::class, 'showConvoGallery'])->name('convo');
    Route::get('/favorites', [FavoriteController::class, 'myFavorites'])->name('favorites.index');
    Route::post('/favorites/add/{id}', [FavoriteController::class, 'addFavorite'])->name('favorites.add');
    Route::post('/favorites/delete/{id}', [FavoriteController::class, 'deleteFavorite'])->name('favorites.delete');
    Route::get('/user/profile', function() { return view('profile');})->name('profile');

    // Add more user routes here
});

// Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');


// Guest routes




////////////////////////////////




// Route::get('/admin/upload_image', function () {
//     return view('admin.upload_image');
// })->name('manageimage');


// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');


// });require __DIR__.'/auth.php';



require __DIR__ . '/auth.php';
