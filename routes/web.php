<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ClientController;
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
    Route::post('/check-flights', [App\Http\Controllers\CheckFlightsTimeController::class, 'checkFlights'])
         ->name('check_flights.submit')
         ->middleware('subscription');
});

Route::get('all_airport_parking_prices', [App\Http\Controllers\AllAirportParkingPrices::class, 'index'])->name('all_airport_parking_prices');
Route::post('all_airport_parking_prices/search_by_dates', [App\Http\Controllers\AllAirportParkingPrices::class, 'search_by_dates'])->name('all_airport_parking_prices.search_by_dates');
Route::post('all_airport_parking_prices/download_excel', [App\Http\Controllers\AllAirportParkingPrices::class, 'download_excel'])->name('all_airport_parking_prices.download_excel');

Route::prefix('admin/clients')->middleware('auth')->group(function () {
    Route::get('/',        [ClientController::class, 'index'])->name('clients.index');
    Route::post('/',       [ClientController::class, 'store'])->name('clients.store');
    Route::post('/{client}/generate-license', [ClientController::class, 'generateLicense']);
    Route::post('/{client}/activate',   [ClientController::class, 'activate']);
    Route::post('/{client}/deactivate', [ClientController::class, 'deactivate']);

    // Offline License Generator
    Route::get('licenses',                        [LicenseController::class, 'index'])->name('licenses.index');
    Route::post('licenses/generate',              [LicenseController::class, 'generate'])->name('licenses.generate');
    Route::post('licenses/verify',                [LicenseController::class, 'verify'])->name('licenses.verify');
    Route::patch('licenses/{license}/suspend',    [LicenseController::class, 'suspend'])->name('licenses.suspend');
    Route::patch('licenses/{license}/reactivate', [LicenseController::class, 'reactivate'])->name('licenses.reactivate');
});
