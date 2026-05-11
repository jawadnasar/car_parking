@extends('layouts.d_layout')

@section('content')
    <div class="container">
        <h1>Flight Results</h1>
        <p>Total Checked: {{ $totalChecked }}</p>
        <p>Total Found: {{ $totalFound }}</p>

        @if(!empty($flights))
            <table class="table">
                <thead>
                    <tr>
                        <th>Flight Number</th>
                        <th>Searched Flight Number</th>
                        <th>Destination</th>
                        <th>Time</th>
                        <th>Terminal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($flights as $flight)
                        <tr>
                            <td>{{ $flight['flight_no'] }}</td>
                            <td>{{ $flight['searched_flight_no'] }}</td>
                            <td>{{ $flight['destination'] }}</td>
                            <td>{{ $flight['time'] }}</td>
                            <td>{{ $flight['terminal'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No flights found.</p>
        @endif
    </div>
@endsection