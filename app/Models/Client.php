<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    protected $fillable = [
        'name', 'email', 'api_key', 'license_key',
        'is_active', 'subscribed_at', 'expires_at'
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'subscribed_at' => 'datetime',
        'expires_at'    => 'datetime',
    ];

    public function hasActiveSubscription(): bool {
        return $this->is_active && $this->expires_at?->isFuture();
    }

    public static function generateApiKey(): string {
        return bin2hex(random_bytes(32));
    }

    public static function generateLicenseKey(): string {
        // Format: GTW-XXXX-XXXX-XXXX-XXXX (easy to type)
        $parts = [];
        for ($i = 0; $i < 4; $i++) {
            $parts[] = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
        }
        return 'GTW-' . implode('-', $parts);
    }
}
