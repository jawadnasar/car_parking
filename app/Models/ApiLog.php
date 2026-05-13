<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    public $timestamps  = false;
    protected $fillable = [
        'type', 'client_name', 'license_key',
        'flights_requested', 'flights_found',
        'status', 'error_message', 'response_time_ms'
    ];

    // Scope for today
    public function scopeToday(\Illuminate\Database\Eloquent\Builder $query) {
        return $query->whereDate('created_at', today());
    }

    // Scope for this week
    public function scopeThisWeek(\Illuminate\Database\Eloquent\Builder $query) {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }
}
