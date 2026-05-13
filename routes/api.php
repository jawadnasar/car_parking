<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CompareAllWebsitesPricesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Login for API User
Route::post('/login', [AuthController::class, 'login']);

// Compare all websites prices
<<<<<<< HEAD
Route::apiResource('update_websites_prices', CompareAllWebsitesPricesController::class);
=======
Route::apiResource('update_websites_prices', CompareAllWebsitesPricesController::class);

Route::post('check-subscription', function (Request $request) {
    $apiKey = $request->input('api_key');
    $client = \App\Models\Client::where('api_key', $apiKey)->first();

    if (!$client) {
        return response()->json(['active' => false, 'message' => 'Client not found']);
    }

    return response()->json([
        'active'     => $client->hasActiveSubscription(),
        'expires_at' => $client->expires_at?->format('d/m/Y'),
        'client'     => $client->name,
    ]);
});

Route::post('validate-license', function (Request $request) {
    $key = $request->input('license_key');
    $client = \App\Models\Client::where('license_key', $key)->first();

    if (!$client) {
        return response()->json([
            'valid'   => false,
            'message' => 'Invalid license key'
        ]);
    }

    $daysLeft = $client->expires_at
        ? max(0, now()->diffInDays($client->expires_at, false))
        : 0;

    return response()->json([
        'valid'       => $client->hasActiveSubscription(),
        'client_name' => $client->name,
        'expires_at'  => $client->expires_at?->format('d/m/Y'),
        'days_left'   => $daysLeft,
        'message'     => $client->hasActiveSubscription()
            ? "License valid — {$daysLeft} days remaining"
            : 'License expired. Please renew.'
    ]);
});

Route::middleware([\App\Http\Middleware\CheckSubscription::class])->group(function () {
    Route::post('fetch-flights', [\App\Http\Controllers\Api\FlightApiController::class, 'fetchFlights']);
});
>>>>>>> 859410876d405b3bca05890f854eef0ee84a2e2e
