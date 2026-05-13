<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedLicense extends Model
{
    protected $fillable = [
        'client_name',
        'expiry_date',
        'license_key',
        'days',
        'status',
    ];

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }
}
