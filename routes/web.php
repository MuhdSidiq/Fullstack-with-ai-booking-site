<?php

use App\Http\Controllers\BillplzCallbackController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CampingSiteController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Camping Sites CRUD routes
Route::resource('camping-sites', CampingSiteController::class);

// Billplz payment routes
Route::get('/bookings/{booking}/billplz-checkout', [BookingController::class, 'billplzCheckout'])->name('billplz.checkout');
Route::post('/billplz/callback', [BillplzCallbackController::class, 'handle'])->name('billplz.callback');

Route::get('/bookings/{booking}/thank-you', [BookingController::class, 'thankYou'])->name('bookings.thank-you');
Route::resource('bookings', BookingController::class);

require __DIR__.'/settings.php';
