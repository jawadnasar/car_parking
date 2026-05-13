<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'flight_id',
        'flight_no',
        'destination',
        'time',
        'terminal',
    ];
}
