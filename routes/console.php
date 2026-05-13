<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
<<<<<<< HEAD
=======

use Illuminate\Support\Facades\Schedule;

Schedule::command('flights:scrape-gatwick')->everyFifteenMinutes();
>>>>>>> 859410876d405b3bca05890f854eef0ee84a2e2e
