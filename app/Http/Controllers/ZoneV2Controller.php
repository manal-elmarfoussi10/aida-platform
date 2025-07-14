<?php

namespace App\Http\Controllers;

use App\Models\ZoneV2;
use App\Models\Site;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Events\AiResponded;
use App\Models\AiRequest;

class ZoneV2Controller extends Controller
{
    public function index(Request $request)
    {
        $sites = Site::with('buildings.floors.zones')->get();
        $selectedSiteId = $request->input('site_id');
        $buildings = $selectedSiteId ? Building::where('site_id', $selectedSiteId)->get() : collect();

        $selectedBuildingId = $request->input('building_id');
        $floors = $selectedBuildingId ? Floor::where('building_id', $selectedBuildingId)->get() : collect();

        $selectedFloorId = $request->input('floor_id');

        $zones = ZoneV2::when($selectedFloorId, function ($query) use ($selectedFloorId) {
            $query->where('floor_id', $selectedFloorId);
        })->get();

        // Add energy metrics for each site
        $baselineUsage = 1000; // ← replace with real baseline if needed
        foreach ($sites as $site) {
            $zones = $site->buildings->flatMap(function ($building) {
                return $building->floors->flatMap->zones;
            });

            $totalUsage = $zones->sum(function ($zone) {
                return floatval($zone->energy_usage ?? 0);
            });

            $site->total_energy_kwh = $totalUsage;
            $site->co2_reduction_kg = round($totalUsage * 0.55, 2);
            $site->savings_percent = $baselineUsage > 0
                ? round((($baselineUsage - $totalUsage) / $baselineUsage) * 100, 1)
                : 0;
        }

        return view('zones-v2.index', compact(
            'zones', 'sites', 'buildings', 'floors',
            'selectedSiteId', 'selectedBuildingId', 'selectedFloorId'
        ));
    }

    public function create()
    {
        $sites = Site::all();
        $buildings = collect(); // empty until site is selected
        $floors = collect();    // empty until building is selected

        return view('zones-v2.create', compact('sites', 'buildings', 'floors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'zone_type' => 'required|string',
            'occupancy' => 'nullable|integer',
            'temperature_humidity' => 'nullable|string',
            'energy_usage' => 'nullable|string',
            'status' => 'nullable|boolean',
            'floor_id' => 'required|exists:floors,id',
        ]);

        ZoneV2::create($validated);

        return redirect()->route('zones-v2.index')->with('success', 'Zone created successfully.');
    }

    public function edit(ZoneV2 $zone)
    {
        $sites = Site::all();
        $buildings = Building::where('site_id', $zone->floor->building->site_id)->get();
        $floors = Floor::where('building_id', $zone->floor->building_id)->get();

        return view('zones-v2.edit', compact('zone', 'sites', 'buildings', 'floors'));
    }

    public function update(Request $request, ZoneV2 $zone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'zone_type' => 'required|string|max:255',
            'status' => 'required|boolean',
            'occupancy' => 'nullable|integer',
            'temperature_humidity' => 'nullable|string|max:50',
            'energy_usage' => 'nullable|string|max:50',
            'floor_id' => 'required|exists:floors,id',
        ]);

        $zone->update($validated);

        return redirect()->route('zones-v2.index')->with('success', 'Zone updated.');
    }

    public function destroy(ZoneV2 $zone)
    {
        $zone->delete();
        return back()->with('success', 'Zone deleted.');
    }

    public function toggle(Request $request, $id)
    {
        $zone = ZoneV2::findOrFail($id);
        $zone->status = $request->input('status');
        $zone->save();

        return response()->json([
            'success' => true,
            'status' => $zone->status
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file));

        foreach ($data as $index => $row) {
            if ($index === 0) continue;

            ZoneV2::create([
                'name' => $row[0] ?? null,
                'zone_type' => $row[1] ?? null,
                'status' => isset($row[2]) ? (bool) $row[2] : false,
                'occupancy' => $row[3] ?? null,
                'temperature_humidity' => $row[4] ?? null,
                'energy_usage' => $row[5] ?? null,
                'floor_id' => $row[6] ?? null,
            ]);
        }

        return redirect()->route('zones-v2.index')->with('success', 'Zones imported successfully.');
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        abort_unless($user, 403);

        $prompt = $request->input('prompt', '');
        $text = 'No response from AI.';

        if (Str::contains(strtolower($prompt), 'how many zones')) {
            $zoneCount = ZoneV2::count();
            $text = "There are $zoneCount zones in the system.";
        } else {
            try {
                $openAiResponse = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a smart building assistant.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.7,
                ]);

                $text = $openAiResponse->json('choices.0.message.content') ?? 'No response from AI.';
            } catch (\Exception $e) {
                $text = '⚠️ API Error: ' . $e->getMessage();
                Log::error('OpenAI API call failed', ['error' => $e->getMessage()]);
            }
        }

        AiRequest::create([
            'user_id' => $user->id,
            'message' => $prompt,
            'response' => $text,
        ]);

        broadcast(new AiResponded($text))->toOthers();

        return response()->json(['response' => $text]);
    }

    // AJAX: buildings by site
    public function getBuildings($siteId)
    {
        return Building::where('site_id', $siteId)->get();
    }

    // AJAX: floors by building
    public function getFloors($buildingId)
    {
        return response()->json(Floor::where('building_id', $buildingId)->get());
    }
    public function getZones($floorId)
{
    return response()->json(
        \App\Models\ZoneV2::where('floor_id', $floorId)->get()
    );
}

}
