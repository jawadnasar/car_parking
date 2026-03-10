<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return 'Welcome to dashboard, ';
    })->name('dashboard');

});

Route::get('all_airport_parking_prices', [App\Http\Controllers\AllAirportParkingPrices::class, 'index']);
Route::post('all_airport_parking_prices/search_by_dates', [App\Http\Controllers\AllAirportParkingPrices::class, 'search_by_dates'])->name('all_airport_parking_prices.search_by_dates');
Route::post('all_airport_parking_prices/download_excel', [App\Http\Controllers\AllAirportParkingPrices::class, 'download_excel'])->name('all_airport_parking_prices.download_excel');

