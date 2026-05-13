@extends('layouts.d_layout')

@section('title', 'Dashboard')
@section('page_title', 'Welcome to Dashboard')

@section('content')
    <div style="max-width: 1200px;">
        <div style="background: white; padding: 2rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); margin-bottom: 2rem;">
            <h2 style="margin-bottom: 1rem; font-size: 1.5rem;">Hello, {{ auth()->user()->name }}! 👋</h2>
            <p style="color: #706f6c; line-height: 1.6;">
                Welcome to your dashboard. Here you can manage your parking website prices and monitor airport parking options.
            </p>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <h3 style="color: #706f6c; font-size: 0.875rem; margin-bottom: 0.5rem;">Total Websites</h3>
                <p style="font-size: 2rem; font-weight: 600;">0</p>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <h3 style="color: #706f6c; font-size: 0.875rem; margin-bottom: 0.5rem;">Total Airports</h3>
                <p style="font-size: 2rem; font-weight: 600;">0</p>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <h3 style="color: #706f6c; font-size: 0.875rem; margin-bottom: 0.5rem;">Last Updated</h3>
                <p style="font-size: 2rem; font-weight: 600;">-</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div style="background: white; padding: 2rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem;">Quick Actions</h3>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('all_airport_parking_prices') }}" style="padding: 0.75rem 1.5rem; background-color: #1b1b18; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; transition: background-color 0.3s;">
                    View Airport Prices
                </a>
                <button style="padding: 0.75rem 1.5rem; background-color: #e3e3e0; color: #1b1b18; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: background-color 0.3s;">
                    Update Prices
                </button>
            </div>
        </div>
<<<<<<< HEAD
=======

        <!-- API Analytics Section -->
        <h2 style="margin:24px 0 16px;">API Analytics</h2>

        <!-- Row 1: Incoming requests -->
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:16px;">

            <div class="stat-card" style="border-left:4px solid #3b82f6; background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <div class="stat-label" style="color: #706f6c; font-size: 0.875rem; margin-bottom: 0.5rem;">Client Requests Today</div>
                <div class="stat-value" style="font-size: 2rem; font-weight: 600;">{{ $stats['incoming_today'] }}</div>
                <div class="stat-sub" style="font-size: 0.875rem; color: #706f6c;">Total: {{ $stats['incoming_total'] }}</div>
            </div>

            <div class="stat-card" style="border-left:4px solid #10b981; background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <div class="stat-label" style="color: #706f6c; font-size: 0.875rem; margin-bottom: 0.5rem;">Flights Served Today</div>
                <div class="stat-value" style="font-size: 2rem; font-weight: 600;">{{ $stats['flights_served_today'] }}</div>
                <div class="stat-sub" style="font-size: 0.875rem; color: #706f6c;">This week: {{ $stats['incoming_week'] }} requests</div>
            </div>

            <div class="stat-card" style="border-left:4px solid #8b5cf6; background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <div class="stat-label" style="color: #706f6c; font-size: 0.875rem; margin-bottom: 0.5rem;">Active Clients</div>
                <div class="stat-value" style="font-size: 2rem; font-weight: 600;">{{ $stats['active_clients'] }}</div>
                <div class="stat-sub" style="font-size: 0.875rem; color: #706f6c;">
                    ✓ {{ $stats['incoming_success'] }} success
                    / ✗ {{ $stats['incoming_failed'] }} failed
                </div>
            </div>
        </div>

        <!-- Row 2: Outgoing to Gatwick -->
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px;">

            <div class="stat-card" style="border-left:4px solid #f59e0b; background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <div class="stat-label" style="color: #706f6c; font-size: 0.875rem; margin-bottom: 0.5rem;">Gatwick Scrapes Today</div>
                <div class="stat-value" style="font-size: 2rem; font-weight: 600;">{{ $stats['outgoing_today'] }}</div>
                <div class="stat-sub" style="font-size: 0.875rem; color: #706f6c;">Total: {{ $stats['outgoing_total'] }}</div>
            </div>

            <div class="stat-card" style="border-left:4px solid #06b6d4; background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <div class="stat-label" style="color: #706f6c; font-size: 0.875rem; margin-bottom: 0.5rem;">Flights Scraped Today</div>
                <div class="stat-value" style="font-size: 2rem; font-weight: 600;">{{ $stats['flights_scraped_today'] }}</div>
                <div class="stat-sub" style="font-size: 0.875rem; color: #706f6c;">This week: {{ $stats['outgoing_week'] }} scrapes</div>
            </div>

            <div class="stat-card" style="border-left:4px solid #ef4444; background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <div class="stat-label" style="color: #706f6c; font-size: 0.875rem; margin-bottom: 0.5rem;">Gatwick Scrape Status</div>
                <div class="stat-value" style="font-size: 2rem; font-weight: 600;" @style(['color: #ef4444' => $stats['outgoing_failed'] > 0, 'color: #10b981' => $stats['outgoing_failed'] == 0])>
                    {{ $stats['outgoing_failed'] > 0 ? 'Issues' : 'Healthy' }}
                </div>
                <div class="stat-sub" style="font-size: 0.875rem; color: #706f6c;">
                    ✓ {{ $stats['outgoing_success'] }} ok
                    / ✗ {{ $stats['outgoing_failed'] }} failed
                </div>
            </div>
        </div>

        <!-- Recent activity tables -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

            <!-- Incoming recent -->
            <div style="background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <h3 style="font-size:14px;margin-bottom:10px;">Recent Client Requests</h3>
                <table style="width:100%;font-size:12px;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f1f5f9;">
                            <th style="padding:6px;text-align:left;">Client</th>
                            <th style="padding:6px;text-align:left;">Flights</th>
                            <th style="padding:6px;text-align:left;">Found</th>
                            <th style="padding:6px;text-align:left;">Time</th>
                            <th style="padding:6px;text-align:left;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_incoming'] as $log)
                        <tr style="border-bottom:1px solid #e5e7eb;">
                            <td style="padding:6px;">{{ $log->client_name }}</td>
                            <td style="padding:6px;">{{ $log->flights_requested }}</td>
                            <td style="padding:6px;">{{ $log->flights_found }}</td>
                            <td style="padding:6px;">{{ $log->response_time_ms }}ms</td>
                            <td style="padding:6px;">
                                <span @style(['color: #10b981' => $log->status === 'success', 'color: #ef4444' => $log->status !== 'success'])>
                                    {{ $log->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Outgoing recent -->
            <div style="background: white; padding: 1.5rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                <h3 style="font-size:14px;margin-bottom:10px;">Recent Gatwick Scrapes</h3>
                <table style="width:100%;font-size:12px;border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f1f5f9;">
                            <th style="padding:6px;text-align:left;">Flights Found</th>
                            <th style="padding:6px;text-align:left;">Duration</th>
                            <th style="padding:6px;text-align:left;">Time</th>
                            <th style="padding:6px;text-align:left;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['recent_outgoing'] as $log)
                        <tr style="border-bottom:1px solid #e5e7eb;">
                            <td style="padding:6px;">{{ $log->flights_found }}</td>
                            <td style="padding:6px;">{{ $log->response_time_ms }}ms</td>
                            <td style="padding:6px;">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i') }}</td>
                            <td style="padding:6px;">
                                <span @style(['color: #10b981' => $log->status === 'success', 'color: #ef4444' => $log->status !== 'success'])>
                                    {{ $log->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
>>>>>>> 859410876d405b3bca05890f854eef0ee84a2e2e
    </div>

    <style>
        body.dark div[style*="background: white"] {
            background-color: #161615 !important;
        }

        body.dark p, body.dark h3 {
            color: #EDEDEC;
        }

        body.dark p[style*="color: #706f6c"] {
            color: #A1A09A !important;
        }
    </style>
@endsection
