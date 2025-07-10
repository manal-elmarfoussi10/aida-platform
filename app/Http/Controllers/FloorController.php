<?php

// app/Http/Controllers/FloorController.php
namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Building;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::with('building')->get();
        return view('floors.index', compact('floors'));
    }

    public function create()
    {
        $buildings = Building::all();
        return view('floors.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255',
        ]);

        Floor::create($request->only('building_id', 'name'));

        return redirect()->route('floors.index')->with('success', 'Floor created successfully.');
    }

    public function edit(Floor $floor)
    {
        $buildings = Building::all();
        return view('floors.edit', compact('floor', 'buildings'));
    }

    public function update(Request $request, Floor $floor)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255',
        ]);

        $floor->update($request->only('building_id', 'name'));

        return redirect()->route('floors.index')->with('success', 'Floor updated successfully.');
    }

    public function destroy(Floor $floor)
    {
        $floor->delete();
        return redirect()->route('floors.index')->with('success', 'Floor deleted successfully.');
    }
}
