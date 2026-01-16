<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CampingSiteController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');



Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Camping Sites CRUD routes
Route::resource('camping-sites', CampingSiteController::class);


require __DIR__.'/settings.php';
