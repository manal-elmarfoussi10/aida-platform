<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\Zone;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        $zones = Zone::all(); // Fetch all zones
    return view('devices.create', compact('zones'));
    }

    public function store(Request $request)
{
    $data = $request->all();

    $data['current_status'] = $request->has('current_status') ? 1 : 0;
    $data['manual_control'] = $request->has('manual_control') ? 1 : 0;

    Device::create($data);

    return redirect()->route('devices.index');
}

    public function edit(Device $device)
    {
        $zones = Zone::all(); // Fetch all zones
    return view('devices.edit', compact('device', 'zones'));
    }

    public function update(Request $request, Device $device)
    {
        $data = $request->all();
    
        $data['current_status'] = $request->has('current_status') ? 1 : 0;
        $data['manual_control'] = $request->has('manual_control') ? 1 : 0;
    
        $device->update($data);
    
        return redirect()->route('devices.index');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index');
    }


  // DeviceController.php

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