<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::all();
        return view('zones.index', compact('zones'));
    }

    public function create()
    {
        return view('zones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $data = $request->all();
    
        $data['maintenance_alert'] = $request->has('maintenance_alert');
        $data['device_control_status'] = $request->has('device_control_status');
    
        Zone::create($data);
    
        return redirect()->route('zones.index')->with('success', 'Zone created successfully.');
    }

    public function edit(Zone $zone)
    {
        return view('zones.edit', compact('zone'));
    }

    public function update(Request $request, Zone $zone)
{
    $data = $request->all();

    $data['maintenance_alert'] = $request->has('maintenance_alert');
    $data['device_control_status'] = $request->has('device_control_status');

    $zone->update($data);

    return redirect()->route('zones.index')->with('success', 'Zone updated successfully.');
}

    public function destroy(Zone $zone)
    {
        $zone->delete();
        return redirect()->route('zones.index')->with('success', 'Zone deleted successfully.');
    }
}