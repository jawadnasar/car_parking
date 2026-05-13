<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapeGatwickFlights extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flights:scrape-gatwick';

    protected $description = 'Scrapes Gatwick LiveFlights and saves them to SQLite database';

    public function handle()
    {
        $this->info('Starting Gatwick flights scraping...');
        
        $startTime     = microtime(true);
        $totalFound    = 0;
        $status        = 'success';
        $errorMessage  = null;

        try {
            $i = 0;

            do {
                $response = \Illuminate\Support\Facades\Http::timeout(10)->get('https://www.gatwickairport.com/on/demandware.store/Sites-Gatwick-Site/en_GB/LiveFlights-FetchFlights', [
                    'page' => $i,
                    'terminal' => 'all',
                    'destination' => 'A', // Arrivals
                    'search' => '',
                ]);

                $f_Data = [];
                
                if ($response->successful()) {
                    $crawler = new \Symfony\Component\DomCrawler\Crawler($response->body());
                    $crawler->filter('.flight-line')->each(function ($node) use (&$f_Data, &$totalFound) {
                        $flightData = [
                            'flight_id' => $node->attr('id') ?: '',
                            'flight_no' => $node->filter('.d-none.d-md-table-cell')->eq(0)->text(''),
                            'destination' => $node->filter('.destination')->text(''),
                            'time' => $node->filter('.time')->text(''),
                            'terminal' => $node->filter('.d-none.d-md-table-cell')->eq(2)->text(''),
                        ];

                        if (!empty($flightData['flight_no'])) {
                            \App\Models\Flight::updateOrCreate(
                                ['flight_no' => $flightData['flight_no'], 'time' => $flightData['time']],
                                $flightData
                            );
                            $f_Data[] = $flightData;
                            $totalFound++;
                        }
                    });
                }

                $i++;
                $this->info("Scraped page $i. Flights on this page: " . count($f_Data));
                sleep(1); // avoid overwhelming the server
                
            } while (!empty($f_Data));

            $this->info("Scraping completed. Total flights scraped: $totalFound");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error scraping flight details: ' . $e->getMessage());
            $this->error('Failed to scrape flights: ' . $e->getMessage());
            
            $status       = 'failed';
            $errorMessage = $e->getMessage();
        }
        
        $responseTime = round((microtime(true) - $startTime) * 1000);

        // Log outgoing request to Gatwick
        \App\Models\ApiLog::create([
            'type'              => 'outgoing',
            'client_name'       => 'Gatwick Airport',
            'flights_requested' => 0,
            'flights_found'     => $totalFound,
            'status'            => $status,
            'error_message'     => $errorMessage,
            'response_time_ms'  => $responseTime,
        ]);
    }
}
