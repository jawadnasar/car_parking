<?php
namespace App\Services;

class LicenseKeyService
{
    private const SECRET = 'GTW-OPS-SECRET-2024-PARKING-SYSTEM';
    private const METHOD = 'AES-256-CBC';

    // Generate encrypted license key
    public static function generate(string $expiryDate, string $clientName): string
    {
        // Data to encrypt: "2026-06-10|John Smith"
        $data      = $expiryDate . '|' . $clientName;
        $secretKey = substr(hash('sha256', self::SECRET, true), 0, 32);
        $ivLen     = openssl_cipher_iv_length(self::METHOD);
        $iv        = random_bytes($ivLen);
        $encrypted = openssl_encrypt($data, self::METHOD, $secretKey, OPENSSL_RAW_DATA, $iv);

        // Base64 encode IV + encrypted data
        return base64_encode($iv . $encrypted);
    }

    // Decrypt and validate a license key
    public static function decrypt(string $licenseKey): array|false
    {
        try {
            $decoded   = base64_decode($licenseKey);
            if (!$decoded) return false;

            $secretKey = substr(hash('sha256', self::SECRET, true), 0, 32);
            $ivLen     = openssl_cipher_iv_length(self::METHOD);
            $iv        = substr($decoded, 0, $ivLen);
            $cipher    = substr($decoded, $ivLen);
            $decrypted = openssl_decrypt($cipher, self::METHOD, $secretKey, OPENSSL_RAW_DATA, $iv);

            if (!$decrypted) return false;

            $parts = explode('|', $decrypted);
            if (count($parts) < 2) return false;

            return [
                'expiry_date' => $parts[0],
                'client_name' => $parts[1],
            ];
        } catch (\Exception $e) {
            return false;
        }
    }

    // Check if license is still valid
    public static function isValid(string $licenseKey): bool
    {
        $data = self::decrypt($licenseKey);
        if (!$data) return false;

        return now()->toDateString() <= $data['expiry_date'];
    }

    // Get days remaining
    public static function daysRemaining(string $licenseKey): int
    {
        $data = self::decrypt($licenseKey);
        if (!$data) return 0;

        $expiry = \Carbon\Carbon::parse($data['expiry_date']);
        return max(0, (int) now()->diffInDays($expiry, false));
    }
}
