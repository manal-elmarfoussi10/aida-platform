<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;
use App\Models\Device;
use App\Models\ZoneV2;

class ControlController extends Controller
{

    public function index()
    {
        $devices = Device::all();
        $device = $devices->first();

        return view('controls.index', compact('devices', 'device'));
    }
  // ControlController.php
  public function controls($id = null)
  {
      $devices = Device::all();
      $device = $id ? Device::findOrFail($id) : $devices->first();
  
      return view('controls.index', compact('devices', 'device'));
  }
  
  public function update(Request $request, $id)
  {
      $device = Device::findOrFail($id);
  
      $device->update([
          'temperature' => $request->input('temperature'),
          'dimmer' => $request->input('dimmer'),
          'color_temperature' => $request->input('color_temperature'),
          'rgb_color' => $request->input('rgb_color'),
          'shades' => $request->input('shades'), // ✅ Make sure this is added
      ]);
  
      return response()->json(['success' => true]);
  }

    public function show($id)
    {
        $devices = Device::all();
        $device = Device::findOrFail($id);

        return view('controls.index', compact('devices', 'device'));
    }

   
}