<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller {
    // Generate license key for client
    public function generateLicense(Client $client) {
        $client->update([
            'license_key' => Client::generateLicenseKey()
        ]);
        return back()->with('success',
            'License key generated: ' . $client->license_key .
            ' — Send this to the client!'
        );
    }

    // Activate subscription for 30 days
    public function activate(Client $client) {
        $client->update([
            'is_active'     => true,
            'subscribed_at' => now(),
            'expires_at'    => now()->addDays(30),
        ]);
        return back()->with('success',
            'Subscription activated for ' . $client->name .
            '. Expires: ' . now()->addDays(30)->format('d/m/Y')
        );
    }

    // Deactivate
    public function deactivate(Client $client) {
        $client->update(['is_active' => false]);
        return back()->with('success', 'Subscription deactivated for ' . $client->name);
    }

    // Create new client with API key
    public function store(Request $request) {
        $client = Client::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'api_key' => Client::generateApiKey(),
        ]);
        return back()->with('success', 'Client created. API Key: ' . $client->api_key);
    }

    // Index page to list clients
    public function index() {
        $clients = Client::all();
        return view('admin.clients', compact('clients'));
    }
}
