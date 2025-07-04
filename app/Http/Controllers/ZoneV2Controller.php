<?php

namespace App\Http\Controllers;

use App\Models\ZoneV2;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ZoneV2Controller extends Controller
{
    // Show all zones
    public function index()
    {
        $zones = ZoneV2::all();
        return view('zones-v2.index', compact('zones'));
    }

    // Show create form
    public function create()
    {
        return view('zones-v2.create');
    }

    // Store new zone
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'zone_type' => 'required|string|max:255',
            'status' => 'required|boolean',
            'occupancy' => 'nullable|integer',
            'temperature_humidity' => 'nullable|string|max:50',
            'energy_usage' => 'nullable|string|max:50',
        ]);

        ZoneV2::create($validated);

        return redirect()->route('zones-v2.index')->with('success', 'Zone added.');
    }

    // Edit a zone
    public function edit(ZoneV2 $zone)
    {
        return view('zones-v2.edit', compact('zone'));
    }

    // Update a zone
    public function update(Request $request, ZoneV2 $zone)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'zone_type' => 'required|string|max:255',
            'status' => 'required|boolean',
            'occupancy' => 'nullable|integer',
            'temperature_humidity' => 'nullable|string|max:50',
            'energy_usage' => 'nullable|string|max:50',
        ]);

        $zone->update($validated);

        return redirect()->route('zones-v2.index')->with('success', 'Zone updated.');
    }

    // Delete a zone
    public function destroy(ZoneV2 $zone)
    {
        $zone->delete();
        return back()->with('success', 'Zone deleted.');
    }
    public function toggle(Request $request, $id)
    {
        $zone = Zone::findOrFail($id);
        $zone->status = $request->input('status');
        $zone->save();
    
        return response()->json([
            'success' => true,
            'status' => $zone->status
        ]);
    }

    //IMPORT
    public function import(Request $request)
{
    $request->validate([
        'csv_file' => 'required|mimes:csv,txt'
    ]);

    $file = $request->file('csv_file');
    $data = array_map('str_getcsv', file($file));

    foreach ($data as $index => $row) {
        if ($index === 0) continue; // Skip header

        ZoneV2::create([
            'name' => $row[0] ?? null,
            'zone_type' => $row[1] ?? null,
            'status' => isset($row[2]) ? (bool) $row[2] : false,
            'occupancy' => $row[3] ?? null,
            'temperature_humidity' => $row[4] ?? null,
            'energy_usage' => $row[5] ?? null,
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

    // Step 1: Check for a custom command
    if (Str::contains(strtolower($prompt), 'how many zones')) {
        $zoneCount = \App\Models\ZoneV2::count();
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
}
