<?php

use App\Http\Controllers\Booking\CancelSlotBookingController;
use App\Http\Controllers\Booking\CreateSlotBookingController;
use App\Http\Controllers\Booking\ListAvailableBarberShopsController;
use App\Http\Controllers\Booking\ShowBarberShopSlotsController;
use App\Http\Controllers\Booking\UserBookingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/barber-shops', ListAvailableBarberShopsController::class)->name('barber-shops.list');
    Route::get('/slots/{barberShop}/{year}/{month}/{day}', ShowBarberShopSlotsController::class)->name('slots.show');
    Route::post('/slots/{barberShop}/{slot}/book', CreateSlotBookingController::class)->name('slots.book');
    Route::post('/slots/{barberShop}/{booking}/cancel', CancelSlotBookingController::class)->name('bookings.cancel');
    Route::get('/my-bookings', UserBookingsController::class)->name('user.bookings');
});

require __DIR__ . '/auth.php';
