<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Device;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('device')->get();
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $devices = Device::all();
        return view('schedules.create', compact('devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'action' => 'required|string',
            'scheduled_at' => 'required|date',
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'Schedule created');
    }
}