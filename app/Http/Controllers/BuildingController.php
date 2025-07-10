<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Site;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the buildings.
     */
    public function index()
    {
        $buildings = Building::with('site')->get(); // eager load site
        return view('buildings.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new building.
     */
    public function create()
    {
        $sites = Site::all(); // for dropdown selection
        return view('buildings.create', compact('sites'));
    }

    /**
     * Store a newly created building in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'nullable|exists:sites,id',
            'name' => 'required|string',
            'type' => 'required|string',
            'size' => 'nullable|numeric',
        ]);

        // Handle status checkbox (true if checked, false if not)
        $validated['status'] = $request->has('status');

        Building::create($validated);

        return redirect()->route('buildings.index')->with('success', 'Building created successfully.');
    }

    /**
     * Display the specified building (optional).
     */
    public function show(Building $building)
    {
        return view('buildings.show', compact('building'));
    }

    /**
     * Show the form for editing the specified building.
     */
    public function edit(Building $building)
    {
        $sites = Site::all(); // for dropdown selection
        return view('buildings.edit', compact('building', 'sites'));
    }

    /**
     * Update the specified building in storage.
     */
    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'site_id' => 'nullable|exists:sites,id',
            'name' => 'required|string',
            'type' => 'required|string',
            'size' => 'nullable|numeric',
        ]);

        // Checkbox: status is only true if checked
        $validated['status'] = $request->has('status');

        $building->update($validated);

        return redirect()->route('buildings.index')->with('success', 'Building updated successfully.');
    }

    /**
     * Remove the specified building from storage.
     */
    public function destroy(Building $building)
    {
        $building->delete();

        return redirect()->route('buildings.index')->with('success', 'Building deleted successfully.');
    }
}