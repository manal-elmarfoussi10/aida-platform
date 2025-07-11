<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\ZoneV2;

class DashboardController extends Controller
{
    public function admin(Request $request)
{
    $sites = Site::all();

    // If no site is selected, default to the first site
    $selectedSite = $request->has('site_id')
        ? Site::find($request->site_id)
        : $sites->first();

    // Default fallback values
    $energyUsage = 0;
    $savingsPercentage = 0;
    $occupancyRate = 0;
    $environmentalImpact = 0;

    if ($selectedSite) {
        // Simulate unique dummy data per site
        switch ($selectedSite->id) {
            case 1: // MHT NEW York City
                $energyUsage = 120.00;
                $savingsPercentage = 25;
                $occupancyRate = 80;
                $environmentalImpact = 45;
                break;

            case 2: // Cisco Atlanta
                $energyUsage = 95.00;
                $savingsPercentage = 32;
                $occupancyRate = 85;
                $environmentalImpact = 52;
                break;

            case 3: // Cisco New York City
                $energyUsage = 110.00;
                $savingsPercentage = 20;
                $occupancyRate = 78;
                $environmentalImpact = 38;
                break;

            case 4: // Cisco San Jose
                $energyUsage = 105.00;
                $savingsPercentage = 28;
                $occupancyRate = 82;
                $environmentalImpact = 48;
                break;

            default:
                $energyUsage = 0;
                $savingsPercentage = 0;
                $occupancyRate = 0;
                $environmentalImpact = 0;
        }
    }

    return view('dashboards.admin', compact(
        'sites',
        'selectedSite',
        'energyUsage',
        'savingsPercentage',
        'occupancyRate',
        'environmentalImpact'
    ));
}

    public function facility()
    {
        return view('dashboards.facility', [
            'comfortScore' => 76,
            'energyUsage' => 1.8,
            'issues' => 1,
            'alerts' => ['🔧 Maintenance due in Zone B']
        ]);
    }

    public function user()
    {
        return view('dashboards.user', [
            'comfortScore' => 91,
            'energyUsage' => 0.7,
            'issues' => 0,
            'alerts' => []
        ]);
    }
}