<?php
namespace App\Http\Controllers;

use App\Models\GeneratedLicense;
use App\Services\LicenseKeyService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LicenseController extends Controller
{
    // ── Allowed day presets ──────────────────────────────────────────
    private const ALLOWED_DAYS = [7, 15, 30, 45, 90, 180, 365];

    // Show generator page
    public function index()
    {
        $licenses = GeneratedLicense::latest()->get();
        return view('admin.generate_license', compact('licenses'));
    }

    // Generate new license key
    public function generate(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:100',
            'days'        => 'required|integer|in:' . implode(',', self::ALLOWED_DAYS),
        ]);

        $days       = (int) $request->days;
        $expiryDate = Carbon::now()->addDays($days)->format('Y-m-d');

        $licenseKey = LicenseKeyService::generate($expiryDate, $request->client_name);

        $license = GeneratedLicense::create([
            'client_name' => $request->client_name,
            'expiry_date' => $expiryDate,
            'license_key' => $licenseKey,
            'days'        => $days,
            'status'      => 'active',
        ]);

        return back()->with([
            'generated_key' => $licenseKey,
            'client_name'   => $request->client_name,
            'expiry_date'   => $expiryDate,
            'days'          => $days,
            'license_id'    => $license->id,
        ]);
    }

    // Suspend a license
    public function suspend(GeneratedLicense $license)
    {
        $license->update(['status' => 'suspended']);
        return back()->with('success', "License for \"{$license->client_name}\" has been suspended.");
    }

    // Reactivate a suspended license
    public function reactivate(GeneratedLicense $license)
    {
        $license->update(['status' => 'active']);
        return back()->with('success', "License for \"{$license->client_name}\" has been reactivated.");
    }

    // Verify a license key (for testing)
    public function verify(Request $request)
    {
        $key  = $request->input('license_key');
        $data = LicenseKeyService::decrypt($key);

        if (!$data) {
            return response()->json(['valid' => false, 'message' => 'Invalid key']);
        }

        // Also check DB status
        $record   = GeneratedLicense::where('license_key', $key)->first();
        $dbStatus = $record ? $record->status : 'unknown';

        $daysLeft = LicenseKeyService::daysRemaining($key);
        $valid    = LicenseKeyService::isValid($key) && $dbStatus === 'active';

        return response()->json([
            'valid'       => $valid,
            'client_name' => $data['client_name'],
            'expiry_date' => $data['expiry_date'],
            'days_left'   => $daysLeft,
            'db_status'   => $dbStatus,
            'message'     => $valid
                ? "{$daysLeft} days remaining"
                : ($dbStatus === 'suspended' ? 'License is suspended' : 'License expired'),
        ]);
    }
}
