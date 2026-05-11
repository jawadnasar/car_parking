<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Client;

class CheckSubscription {
    public function handle(Request $request, Closure $next): Response {
        $apiKey = $request->header('X-API-Key')
                  ?? $request->input('api_key');

        if (!$apiKey) {
            return response()->json([
                'error' => 'API key required'
            ], 401);
        }

        $client = Client::where('api_key', $apiKey)
                        ->where('is_active', true)
                        ->where('expires_at', '>', now())
                        ->first();

        if (!$client) {
            return response()->json([
                'error'   => 'Subscription expired or invalid',
                'message' => 'Please renew your monthly subscription',
                'code'    => 'SUBSCRIPTION_REQUIRED'
            ], 403);
        }

        $request->merge(['client' => $client]);
        return $next($request);
    }
}
