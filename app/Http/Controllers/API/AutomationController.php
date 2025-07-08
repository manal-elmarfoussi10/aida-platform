<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Automation;
use App\Models\ZoneV2;

class AutomationController extends Controller
{
    /**
     * Display a listing of the automations (optional filter by zone).
     */
    public function index(Request $request)
    {
        $zoneId = $request->query('zone');

        $query = Automation::query();

        if ($zoneId) {
            $query->where('zonev2_id', $zoneId);
        }

        return response()->json([
            'automations' => $query->get()
        ]);
    }

    /**
     * Store a newly created automation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'zonev2_id' => 'required|exists:zones_v2,id',
            // Add other validation rules as needed
        ]);

        $automation = Automation::create($request->all());

        return response()->json([
            'message' => 'Automation created successfully',
            'automation' => $automation
        ], 201);
    }

    /**
     * Display the specified automation.
     */
    public function show($id)
    {
        $automation = Automation::findOrFail($id);

        return response()->json([
            'automation' => $automation
        ]);
    }

    /**
     * Update the specified automation.
     */
    public function update(Request $request, $id)
    {
        $automation = Automation::findOrFail($id);

        $automation->update($request->all());

        return response()->json([
            'message' => 'Automation updated successfully',
            'automation' => $automation
        ]);
    }

    /**
     * Remove the specified automation.
     */
    public function destroy($id)
    {
        $automation = Automation::findOrFail($id);
        $automation->delete();

        return response()->json([
            'message' => 'Automation deleted successfully'
        ]);
    }

    public function editor()
    {
        $zones = ZoneV2::all();
        return view('automations.editor', compact('zones'));
    }
}