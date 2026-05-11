@extends('layouts.d_layout')

@section('title', 'Check Flights')
@section('page_title', 'Check Flight Times')

@section('content')
    <div style="max-width: 900px;">
        <!-- Upload Section -->
        <div style="background: white; padding: 2rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); margin-bottom: 2rem;">
            <h2 style="margin-bottom: 1.5rem; font-size: 1.5rem;">Flight Details Checker</h2>

            @if ($errors->any())
                <div style="background-color: #fff2f2; color: #f53003; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem; border: 1px solid #f5300333;">
                    <strong>Error:</strong>
                    <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('check_flights.submit') }}" enctype="multipart/form-data">
                @csrf

                <!-- Airport Selection -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="airport_id" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Select Airport</label>
                    <select 
                        name="airport_id" 
                        id="airport_id"
                        required
                        style="width: 100%; padding: 0.75rem; border: 1px solid #e3e3e0; border-radius: 0.375rem; font-size: 1rem; background-color: white; color: #1b1b18; cursor: pointer;"
                    >
                        @forelse ($airports as $airport)
                            <option value="{{ $airport->id }}" @if($loop->first) selected @endif>
                                {{ $airport->name }} ({{ $airport->code ?? 'N/A' }})
                            </option>
                        @empty
                            <option value="">No airports available</option>
                        @endforelse
                    </select>
                    @error('airport_id')
                        <div style="color: #f53003; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- File Upload -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="flights_file" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Upload Flight Numbers (Excel/CSV)</label>
                    
                    <div style="
                        border: 2px dashed #e3e3e0;
                        border-radius: 0.375rem;
                        padding: 2rem;
                        text-align: center;
                        cursor: pointer;
                        transition: all 0.3s;
                        background-color: #fafaf9;
                    " id="dropZone"
                    >
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">📄</div>
                        <p style="margin: 0.5rem 0;">Click to upload or drag and drop</p>
                        <p style="margin: 0; font-size: 0.875rem; color: #706f6c;">Excel (.xlsx, .xls) or CSV files</p>
                        <input 
                            type="file" 
                            name="flights_file" 
                            id="flights_file"
                            accept=".xlsx,.xls,.csv"
                            required
                            style="display: none;"
                        >
                    </div>
                    <div id="fileName" style="margin-top: 0.5rem; font-size: 0.875rem; color: #706f6c;"></div>
                    @error('flights_file')
                        <div style="color: #f53003; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Instructions -->
                <div style="background-color: #f9f8f6; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem; border-left: 4px solid #1b1b18;">
                    <p style="margin: 0; font-size: 0.875rem; color: #706f6c;">
                        <strong>File Instructions:</strong> Your Excel or CSV file should have one flight number per row in the first column.
                    </p>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    style="
                        padding: 0.75rem 2rem;
                        background-color: #1b1b18;
                        color: white;
                        border: none;
                        border-radius: 0.375rem;
                        font-weight: 500;
                        cursor: pointer;
                        font-size: 1rem;
                        transition: background-color 0.3s;
                    "
                    onmouseover="this.style.backgroundColor='#0a0a0a'"
                    onmouseout="this.style.backgroundColor='#1b1b18'"
                >
                    Check Flight Details
                </button>
            </form>
        </div>

        <!-- Information Section -->
        <div style="background: white; padding: 2rem; border-radius: 0.375rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
            <h3 style="margin-bottom: 1rem; font-size: 1.25rem;">How It Works</h3>
            <ol style="color: #706f6c; line-height: 1.8;">
                <li>Select an airport from the dropdown menu</li>
                <li>Prepare an Excel or CSV file with flight numbers (one per row)</li>
                <li>Upload the file using the form above</li>
                <li>The system will check flight details for each flight number</li>
                <li>View the results with departure/arrival times and aircraft details</li>
            </ol>
        </div>
    </div>

    <style>
        body.dark div[style*="background: white"] {
            background-color: #161615 !important;
        }

        body.dark select {
            background-color: #0a0a0a !important;
            border-color: #3E3E3A !important;
            color: #EDEDEC !important;
        }

        body.dark #dropZone {
            background-color: #0a0a0a !important;
            border-color: #3E3E3A !important;
        }

        body.dark p, body.dark li, body.dark label {
            color: #EDEDEC;
        }

        body.dark p[style*="color: #706f6c"] {
            color: #A1A09A !important;
        }

        body.dark div[style*="background-color: #f9f8f6"] {
            background-color: #1a1a18 !important;
            border-color: #3E3E3A !important;
        }
    </style>

    <script>
        // File upload with drag and drop
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('flights_file');
        const fileName = document.getElementById('fileName');

        // Click to upload
        dropZone.addEventListener('click', () => fileInput.click());

        // Drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.backgroundColor = '#e3e3e0';
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.style.backgroundColor = '#fafaf9';
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.backgroundColor = '#fafaf9';
            fileInput.files = e.dataTransfer.files;
            updateFileName();
        });

        // File selection
        fileInput.addEventListener('change', updateFileName);

        function updateFileName() {
            if (fileInput.files.length > 0) {
                fileName.textContent = '✓ Selected: ' + fileInput.files[0].name;
                fileName.style.color = '#059669';
            } else {
                fileName.textContent = '';
            }
        }
    </script>
@endsection
