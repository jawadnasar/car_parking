<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Client;
use App\Models\GeneratedLicense;
use App\Services\LicenseKeyService;

class CheckSubscription {
    public function handle(Request $request, Closure $next): Response {
        $apiKey = $request->header('X-API-Key')
                  ?? $request->input('api_key');

        if (!$apiKey) {
            return response()->json([
                'error' => 'API key required'
            ], 401);
        }

        // First: check Client table (legacy api_key)
        $client = Client::where('api_key', $apiKey)
                        ->where('is_active', true)
                        ->where('expires_at', '>', now())
                        ->first();

        if ($client) {
            $request->merge(['client' => $client]);
            return $next($request);
        }

        // Second: check GeneratedLicense table (Offline License Generator keys)
        $genLicense = GeneratedLicense::where('license_key', $apiKey)->first();

        if ($genLicense && $genLicense->status === 'active' && $genLicense->expiry_date >= now()->toDateString()) {
            // Create a lightweight client-like object for logging
            $request->merge(['client' => (object)[
                'name'   => $genLicense->client_name,
                'api_key' => $apiKey,
            ]]);
            return $next($request);
        }

        return response()->json([
            'error'   => 'Subscription expired or invalid',
            'message' => 'Please renew your monthly subscription',
            'code'    => 'SUBSCRIPTION_REQUIRED'
        ], 403);
    }
}
