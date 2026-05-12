<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function dashboard()
    {
        // Existing stats
        $totalWebsites = \App\Models\ParkingWebsite::count();
        $totalAirports = \App\Models\Airport::count();

        // API Analytics
        $stats = [
            // Incoming (client → senior)
            'incoming_today'       => \App\Models\ApiLog::where('type','incoming')->today()->count(),
            'incoming_week'        => \App\Models\ApiLog::where('type','incoming')->thisWeek()->count(),
            'incoming_total'       => \App\Models\ApiLog::where('type','incoming')->count(),
            'incoming_success'     => \App\Models\ApiLog::where('type','incoming')->where('status','success')->count(),
            'incoming_failed'      => \App\Models\ApiLog::where('type','incoming')->where('status','failed')->count(),
            'flights_served_today' => \App\Models\ApiLog::where('type','incoming')->today()->sum('flights_found'),

            // Outgoing (senior → Gatwick)
            'outgoing_today'       => \App\Models\ApiLog::where('type','outgoing')->today()->count(),
            'outgoing_week'        => \App\Models\ApiLog::where('type','outgoing')->thisWeek()->count(),
            'outgoing_total'       => \App\Models\ApiLog::where('type','outgoing')->count(),
            'outgoing_success'     => \App\Models\ApiLog::where('type','outgoing')->where('status','success')->count(),
            'outgoing_failed'      => \App\Models\ApiLog::where('type','outgoing')->where('status','failed')->count(),
            'flights_scraped_today'=> \App\Models\ApiLog::where('type','outgoing')->today()->sum('flights_found'),

            // Recent logs
            'recent_incoming'      => \App\Models\ApiLog::where('type','incoming')->latest('created_at')->limit(10)->get(),
            'recent_outgoing'      => \App\Models\ApiLog::where('type','outgoing')->latest('created_at')->limit(10)->get(),

            // Active clients
            'active_clients'       => \App\Models\Client::where('is_active',1)->where('expires_at','>',now())->count(),
        ];

        return view('dashboard.dashboard', compact('totalWebsites', 'totalAirports', 'stats'));
    }
}
