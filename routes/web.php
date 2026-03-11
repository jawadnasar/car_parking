<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    
    // Flight checking routes
    Route::get('/check-flights', [App\Http\Controllers\CheckFlightsTimeController::class, 'show'])->name('check_flights');
    Route::post('/check-flights', [App\Http\Controllers\CheckFlightsTimeController::class, 'checkFlights'])->name('check_flights.submit');
});

Route::get('all_airport_parking_prices', [App\Http\Controllers\AllAirportParkingPrices::class, 'index'])->name('all_airport_parking_prices');
Route::post('all_airport_parking_prices/search_by_dates', [App\Http\Controllers\AllAirportParkingPrices::class, 'search_by_dates'])->name('all_airport_parking_prices.search_by_dates');
Route::post('all_airport_parking_prices/download_excel', [App\Http\Controllers\AllAirportParkingPrices::class, 'download_excel'])->name('all_airport_parking_prices.download_excel');

