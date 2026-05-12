<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlightApiController extends Controller
{
    public function fetchFlights(Request $request)
    {
        $startTime = microtime(true);

        // Get client info from middleware
        $client        = $request->input('client');
        $flightNumbers = $request->input('flight_numbers', []);

        // Find matching flights from DB
        $found = \App\Models\Flight::where(function($q) use ($flightNumbers) {
            foreach ($flightNumbers as $fn) {
                $q->orWhere('flight_no', 'like', '%' . $fn . '%');
            }
        })->get();

        $responseTime = round((microtime(true) - $startTime) * 1000);

        // Log incoming request
        \App\Models\ApiLog::create([
            'type'              => 'incoming',
            'client_name'       => $client?->name ?? 'Unknown',
            'license_key'       => $request->input('api_key', ''),
            'flights_requested' => count($flightNumbers),
            'flights_found'     => $found->count(),
            'status'            => 'success',
            'response_time_ms'  => $responseTime,
        ]);

        return response()->json([
            'success' => true,
            'flights' => $found->map(fn($f) => [
                'flight_no'          => $f->flight_no,
                'searched_flight_no' => $f->flight_no,
                'destination'        => $f->destination,
                'time'               => $f->time,
                'status'             => $f->status,
                'terminal'           => $f->terminal,
            ])
        ]);
    }
}
