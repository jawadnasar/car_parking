<?php
namespace App\Http\Controllers;

use App\Services\LicenseKeyService;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    // Show generator page
    public function index()
    {
        $licenses = \App\Models\GeneratedLicense::latest()->get();
        return view('admin.generate_license', compact('licenses'));
    }

    // Generate new license key
    public function generate(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:100',
            'expiry_date' => 'required|date|after:today',
        ]);

        $licenseKey = LicenseKeyService::generate(
            $request->expiry_date,
            $request->client_name
        );

        // Save to DB so admin can track
        \App\Models\GeneratedLicense::create([
            'client_name' => $request->client_name,
            'expiry_date' => $request->expiry_date,
            'license_key' => $licenseKey,
            'days'        => now()->diffInDays($request->expiry_date),
        ]);

        return back()->with([
            'generated_key'  => $licenseKey,
            'client_name'    => $request->client_name,
            'expiry_date'    => $request->expiry_date,
            'days'           => now()->diffInDays($request->expiry_date),
        ]);
    }

    // Verify a license key (for testing)
    public function verify(Request $request)
    {
        $key  = $request->input('license_key');
        $data = LicenseKeyService::decrypt($key);

        if (!$data) {
            return response()->json(['valid' => false, 'message' => 'Invalid key']);
        }

        $daysLeft = LicenseKeyService::daysRemaining($key);
        $valid    = LicenseKeyService::isValid($key);

        return response()->json([
            'valid'       => $valid,
            'client_name' => $data['client_name'],
            'expiry_date' => $data['expiry_date'],
            'days_left'   => $daysLeft,
            'message'     => $valid
                ? "{$daysLeft} days remaining"
                : 'License expired',
        ]);
    }
}
