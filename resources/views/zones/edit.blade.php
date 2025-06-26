@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto text-white">
    <h2 class="text-3xl font-bold mb-6">Edit Zone</h2>

    <form action="{{ route('zones.update', $zone) }}" method="POST" class="space-y-6 bg-[#1f1f1f] p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm mb-1 font-semibold">Zone Name</label>
            <input type="text" name="name" value="{{ $zone->name }}"
                   class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-green-400" required>
        </div>

        <div>
            <select name="comfort_status" value="{{ $zone->comfort_status }}"
            class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
        <option value="Comfortable">Comfortable</option>
        <option value="Too Hot">Too Hot</option>
        <option value="Too Cold">Too Cold</option>
        <option value="Too Humid">Too Humid</option>
        <option value="Too Dry">Too Dry</option>
        <option value="Unoccupied">Unoccupied</option>
    </select>
            
        </div>

        <div>
            <label class="block text-sm mb-1 font-semibold">Energy Usage (kWh)</label>
            <input type="text" name="energy_usage" value="{{ $zone->energy_usage }}"
                   class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div>
            <label class="block text-sm mb-1 font-semibold">Device Type</label>
            <select name="device_type"
                    class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-green-400">
                <option {{ $zone->device_type == 'Light' ? 'selected' : '' }}>Light</option>
                <option {{ $zone->device_type == 'HVAC' ? 'selected' : '' }}>HVAC</option>
                <option {{ $zone->device_type == 'Shade' ? 'selected' : '' }}>Shade</option>
            </select>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="maintenance_alert" id="maintenance_alert"
                   class="mr-2 rounded text-green-500 focus:ring-green-400"
                   {{ $zone->maintenance_alert ? 'checked' : '' }}>
            <label for="maintenance_alert" class="text-sm font-medium">Maintenance Alert</label>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="device_control_status" id="device_control_status"
                   class="mr-2 rounded text-green-500 focus:ring-green-400"
                   {{ $zone->device_control_status ? 'checked' : '' }}>
            <label for="device_control_status" class="text-sm font-medium">Device Control Status</label>
        </div>

        <div>
            <button type="submit"
                    class="bg-green-500 hover:bg-green-400 text-black px-6 py-2 rounded font-semibold shadow transition-all">
                Update Zone
            </button>
        </div>
    </form>
</div>
@endsection