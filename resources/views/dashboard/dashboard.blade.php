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
