@extends('layouts.d_layout')

@section('title', 'Offline License Generator')
@section('page_title', 'Offline License Generator')

@section('content')
    <div style="max-width: 1200px; display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; align-items: start;">
        
        <!-- Left Column: Generator Form -->
        <div style="background: white; padding: 2rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem; font-weight: 600;">Create New License</h3>
            
            @if ($errors->any())
                <div style="margin-bottom: 1rem; background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: 0.375rem;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('licenses.generate') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1rem;">
                    <label for="client_name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Client Name</label>
                    <input type="text" name="client_name" id="client_name" required
                           style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;"
                           placeholder="e.g. Acme Corp">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="expiry_date" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" required
                           value="{{ now()->addDays(30)->format('Y-m-d') }}"
                           style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-sizing: border-box;">
                </div>

                <button type="submit" style="width: 100%; background-color: #1b1b18; color: white; padding: 0.75rem; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: background-color 0.2s;">
                    Generate License Key
                </button>
            </form>

            @if(session('generated_key'))
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                    <h4 style="font-size: 1rem; font-weight: 600; color: #16a34a; margin-bottom: 0.5rem;">License Generated Successfully!</h4>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                        This key expires on {{ \Carbon\Carbon::parse(session('expiry_date'))->format('d/m/Y') }} ({{ session('days') }} days).
                    </p>
                    
                    <div style="position: relative;">
                        <textarea id="generated_key_box" readonly rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-family: monospace; font-size: 0.875rem; background-color: #f9fafb; resize: none; box-sizing: border-box;">{{ session('generated_key') }}</textarea>
                        
                        <button type="button" onclick="copyToClipboard()" style="margin-top: 0.5rem; width: 100%; background-color: #f3f4f6; color: #374151; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">
                            📋 Copy to Clipboard
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Generated Keys List -->
        <div style="background: white; padding: 2rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); overflow-x: auto;">
            <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem; font-weight: 600;">Recently Generated Keys</h3>
            
            @if($licenses->isEmpty())
                <p style="color: #6b7280; font-size: 0.875rem;">No keys generated yet.</p>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <tr>
                            <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Client</th>
                            <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Expiry</th>
                            <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Days</th>
                            <th style="padding: 0.75rem 1rem; text-align: left; font-size: 0.75rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em;">Generated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($licenses as $license)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 0.75rem 1rem; font-size: 0.875rem; font-weight: 500; color: #111827;">{{ $license->client_name }}</td>
                                <td style="padding: 0.75rem 1rem; font-size: 0.875rem; color: #6b7280;">{{ \Carbon\Carbon::parse($license->expiry_date)->format('d/m/Y') }}</td>
                                <td style="padding: 0.75rem 1rem; font-size: 0.875rem;">
                                    <span style="padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-weight: 600; font-size: 0.75rem; background-color: #e0e7ff; color: #3730a3;">{{ $license->days }}</span>
                                </td>
                                <td style="padding: 0.75rem 1rem; font-size: 0.75rem; color: #9ca3af;">{{ $license->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("generated_key_box");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */
            document.execCommand("copy");
            alert("Copied the key: " + copyText.value.substring(0, 20) + "...");
        }
    </script>
@endsection
