@extends('layouts.d_layout')

@section('title', 'Clients License Management')
@section('page_title', 'Clients License Management')

@section('content')
    <div style="max-width: 1200px;">
        @if(session('success'))
            <div style="margin-bottom: 1rem; background-color: #d1fae5; border: 1px solid #34d399; color: #065f46; padding: 1rem; border-radius: 0.375rem;" role="alert">
                <span style="display: block;">{{ session('success') }}</span>
            </div>
        @endif

        <div style="background: white; padding: 2rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); overflow-x: auto;">
            <table style="min-width: 100%; width: 100%; border-collapse: collapse;">
                <thead style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                    <tr>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Name</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Email</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">License Key</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Expires</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Days Remaining</th>
                        <th style="padding: 0.75rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Actions</th>
                    </tr>
                </thead>
                <tbody style="background: white;">
                    @foreach($clients as $client)
                        @php
                            $daysLeft = $client->expires_at
                                ? max(0, now()->diffInDays($client->expires_at, false))
                                : 0;
                        @endphp
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: 1rem 1.5rem; white-space: nowrap;">{{ $client->name }}</td>
                            <td style="padding: 1rem 1.5rem; white-space: nowrap;">{{ $client->email }}</td>
                            <td style="padding: 1rem 1.5rem; white-space: nowrap; font-family: monospace; font-size: 0.875rem;">
                                {{ $client->license_key ?? 'None' }}
                            </td>
                            <td style="padding: 1rem 1.5rem; white-space: nowrap;">
                                @if($client->is_active)
                                    <span style="padding: 0.25rem 0.5rem; display: inline-flex; font-size: 0.75rem; font-weight: 600; border-radius: 9999px; background-color: #d1fae5; color: #065f46;">Active</span>
                                @else
                                    <span style="padding: 0.25rem 0.5rem; display: inline-flex; font-size: 0.75rem; font-weight: 600; border-radius: 9999px; background-color: #fee2e2; color: #991b1b;">Inactive</span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem; white-space: nowrap;">
                                {{ $client->expires_at ? $client->expires_at->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td style="padding: 1rem 1.5rem; white-space: nowrap;">
                                @if(!$client->expires_at || $daysLeft == 0)
                                    <span style="padding: 0.25rem 0.5rem; font-size: 0.75rem; font-weight: bold; border-radius: 0.25rem; background-color: #fee2e2; color: #991b1b;">Expired</span>
                                @elseif($daysLeft <= 7)
                                    <span style="padding: 0.25rem 0.5rem; font-size: 0.75rem; font-weight: bold; border-radius: 0.25rem; background-color: #fef3c7; color: #92400e;">{{ $daysLeft }} days</span>
                                @else
                                    <span style="padding: 0.25rem 0.5rem; font-size: 0.75rem; font-weight: bold; border-radius: 0.25rem; background-color: #d1fae5; color: #065f46;">{{ $daysLeft }} days</span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.5rem; white-space: nowrap; font-size: 0.875rem; font-weight: 500; display: flex; gap: 0.5rem;">
                                <form action="{{ url('admin/clients/'.$client->id.'/generate-license') }}" method="POST">
                                    @csrf
                                    <button type="submit" style="color: #2563eb; background-color: #dbeafe; padding: 0.25rem 0.75rem; border-radius: 0.25rem; border: none; cursor: pointer;">Generate Key</button>
                                </form>
                                
                                <form action="{{ url('admin/clients/'.$client->id.'/activate') }}" method="POST">
                                    @csrf
                                    <button type="submit" style="color: #16a34a; background-color: #dcfce3; padding: 0.25rem 0.75rem; border-radius: 0.25rem; border: none; cursor: pointer;">Activate (30 days)</button>
                                </form>

                                <form action="{{ url('admin/clients/'.$client->id.'/deactivate') }}" method="POST">
                                    @csrf
                                    <button type="submit" style="color: #dc2626; background-color: #fee2e2; padding: 0.25rem 0.75rem; border-radius: 0.25rem; border: none; cursor: pointer;">Deactivate</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
