<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Models\ZoneV2;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::with('buildings')->get();
        return view('sites.index', compact('sites'));
    }
    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->route('sites.index')->with('success', 'Site deleted successfully.');
    }

    public function show(Site $site)
    {
        $site->load('buildings.floors');
        return view('sites.show', compact('site'));
    }

    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        $imageMaxSize = 512000; // 500MB

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'image_file' => "nullable|image|mimes:jpeg,png,jpg|max:$imageMaxSize",
            'image_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_path'] = $request->file('image_file')->store('sites', 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image_path'] = $request->input('image_url');
        }

        Site::create($validated);

        return redirect()->route('sites.index')->with('success', 'Site created successfully.');
    }

    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    public function update(Request $request, Site $site)
    {
        $imageMaxSize = 512000; // 500MB

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'image_file' => "nullable|image|mimes:jpeg,png,jpg|max:$imageMaxSize",
            'image_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image_file')) {
            $validated['image_path'] = $request->file('image_file')->store('sites', 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image_path'] = $request->input('image_url');
        }

        $site->update($validated);

        return redirect()->route('sites.index')->with('success', 'Site updated successfully.');
    }

    public function dashboard(Site $site)
{
    // Get all zones under the site's buildings & floors
    $zones = ZoneV2::whereHas('floor.building', function ($query) use ($site) {
        $query->where('site_id', $site->id);
    })->get();

    // Total Energy Usage (kWh)
    $totalEnergyUsage = $zones->sum(function ($zone) {
        return floatval($zone->energy_usage ?? 0);
    });

    // Energy Savings (%) compared to baseline
    $baselineUsage = 1000; // you can replace this with a real baseline
    $savingsPercent = $baselineUsage > 0
        ? round((($baselineUsage - $totalEnergyUsage) / $baselineUsage) * 100, 1)
        : 0;

    // Occupancy Rate (%)
    $totalOccupancy = $zones->sum('occupancy');
    $maxPeoplePerZone = 10; // adjust based on your expected max occupancy
    $maxOccupancy = $zones->count() * $maxPeoplePerZone;
    $occupancyRate = $maxOccupancy > 0
        ? round(($totalOccupancy / $maxOccupancy) * 100, 1)
        : 0;

    // CO₂ Impact (kg saved)
    $co2ReductionKg = round($totalEnergyUsage * 0.55, 2);

    return view('dashboard.site', compact(
        'site',
        'totalEnergyUsage',
        'savingsPercent',
        'occupancyRate',
        'co2ReductionKg'
    ));
}
}