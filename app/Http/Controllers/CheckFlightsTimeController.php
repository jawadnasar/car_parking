<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class CheckFlightsTimeController extends Controller
{
    /**
     * Display the flight checker page
     */
    public function show()
    {
        $airports = Airport::all();

        return view('dashboard.check_flights', [
            'airports' => $airports,
        ]);
    }

    /**
     * Handle file upload and check flights
     */
    public function checkFlights(Request $request)
    {
        $request->validate([
            'airport_id' => 'required|exists:airports,id',
            'flights_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        // Get the airport
        $airport = Airport::find($request->airport_id);

        // Import flight numbers from Excel
        $flightNumbers = $this->importFlightNumbers($request->file('flights_file'));
        if (empty($flightNumbers)) {
            return back()->withErrors(['flights_file' => 'No flight numbers found in the file.']);
        }

        // Departure flights
        // $departure_flights_array = $this->getGatwickFlightDetails($arrival_departure = 'D'); // 'A' for arrivals, 'D' for departures
        // $flight_times = $this->get_flight_times($flightNumbers, $departure_flights_array);
          
        // Arrival flights
        $arrival_flights = $this->getGatwickFlightDetails($arrival_departure = 'A'); // 'A' for arrivals, 'D' for departures
        $flights = $this->search_flights_by_flight_number($flightNumbers, $arrival_flights);
       
        return view('dashboard.flight_results', [
            'airport' => $airport,
            'flights' => $flights,
            'totalChecked' => count($flightNumbers),
            'totalFound' => count($flights),
        ]);
    }

    /**
     * Import flight numbers from Excel file
     */
    private function importFlightNumbers($file)
    {
        $data = [];

        try {
            $content = Excel::toArray(null, $file);

            // Flatten the array and get all non-empty values from the first column
            if (!empty($content[0])) {
                foreach ($content[0] as $row) {
                    $flightNumber = trim($row[0] ?? '');
                    if (!empty($flightNumber)) {
                        $data[] = $flightNumber;
                    }
                }
            }
        } catch (\Exception $e) {
            // If Excel parsing fails, try CSV
            $handle = fopen($file->getRealPath(), 'r');
            while (($line = fgetcsv($handle)) !== false) {
                $flightNumber = trim($line[0] ?? '');
                if (!empty($flightNumber)) {
                    $data[] = $flightNumber;
                }
            }
            fclose($handle);
        }

        return array_unique($data);
    }

    /**     * Scrape Gatwick flight details
     */
    private function getGatwickFlightDetails($arrival_departure)
    {
        try {
            $i = 0;
            $allFlights = []; // Search through each flight row

            do {
                $response = Http::timeout(10)->get('https://www.gatwickairport.com/on/demandware.store/Sites-Gatwick-Site/en_GB/LiveFlights-FetchFlights', [
                    'page' => $i,
                    'terminal' => 'all',
                    'destination' => $arrival_departure,
                    'search' => '',
                ]);
                if ($response->successful()) {
                    $data = $response->body();

                    $crawler = new \Symfony\Component\DomCrawler\Crawler($response->body());
                    $f_Data = []; // This will hold the flight data for the current page
                    $crawler->filter('.flight-line')->each(function ($node, $index) use (&$f_Data, &$allFlights) {
                        $f_Data = [
                            'flight_id' => $node->attr('id') ?: '',
                            'flight_no' => $node->filter('.d-none.d-md-table-cell')->eq(0)->text(''),
                            'destination' => $node->filter('.destination')->text(''),
                            'time' => $node->filter('.time')->text(''),
                            'terminal' => $node->filter('.d-none.d-md-table-cell')->eq(2)->text(''),
                        ];
                        $allFlights[] = $f_Data; // Add the flight data to the main array
                    });
                }
                $i++;
                sleep(1); // Sleep for 1 second to avoid overwhelming the server
            } while ($f_Data && count($f_Data)); // If no flights are found, stop the loop
            return $allFlights;
        } catch (\Exception $e) {
            Log::error('Error scraping flight details: ' . $e->getMessage());
        }
    }

    /**
     * Get flight times for a specific flight number
     */
    private function search_flights_by_flight_number($flightNumbers, $flights)
    {
        foreach ($flightNumbers as $f_number) {
            // Search for the flight number in the flights array
            $flight[0] = collect($flights)->first(function ($flight) use ($f_number) {
                // Check if flight_no contains the search number
                return str_contains($flight['flight_no'], $f_number);
            });
            if($flight[0]){
                $flight[0]['searched_flight_no'] = $f_number; // Add the searched flight number to the result
                $foundFlights[] = $flight[0]; // Add the found flight to the results array
            }   
        }
        if(empty($foundFlights)){
            return [];
        }
        $foundFlights = array_filter($foundFlights); // Remove null values
       return collect($foundFlights)->sortBy('time')->values()->all();
    }
}
