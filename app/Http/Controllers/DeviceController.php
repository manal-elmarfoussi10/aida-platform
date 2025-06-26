<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        Device::create($request->all());
        return redirect()->route('devices.index');
    }

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $device->update($request->all());
        return redirect()->route('devices.index');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index');
    }

    public function toggleStatus(Device $device)
    {
        $device->current_status = !$device->current_status;
        $device->save();
        return response()->json(['status' => $device->current_status]);
    }

    public function toggleManual(Device $device)
    {
        $device->manual_control = !$device->manual_control;
        $device->save();
        return response()->json(['manual' => $device->manual_control]);
    }
}