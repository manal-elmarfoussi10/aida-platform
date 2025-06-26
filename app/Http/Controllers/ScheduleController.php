<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Device;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    // Show calendar view
    public function index()
    {
        $schedules = Schedule::with('device')->get();
    
        $events = $schedules->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->action . ' - ' . optional($item->device)->name,
                'start' => Carbon::parse($item->scheduled_time)->toIso8601String(),
                'color' => '#22c55e',
            ];
        });
    
        return view('schedules.index', compact('events'));
    }
    
    public function events()
    {
        $events = Schedule::with('device')->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->action . ' - ' . optional($item->device)->name,
                'start' => $item->scheduled_time,
                'color' => '#22c55e',
            ];
        });
    
        return response()->json($events);
    }

    // Show form to create new schedule
    public function create()
    {
        $devices = Device::all();
        return view('schedules.create', compact('devices'));
    }

    // Store schedule in database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'action' => 'required|string|max:255',
            'scheduled_time' => 'required|date',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    // (Optional) Delete schedule
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Schedule deleted.');
    }
}