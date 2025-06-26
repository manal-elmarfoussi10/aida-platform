@extends('layouts.app')
@section('title', 'Add New Zone')

@section('content')
<div class="p-8 max-w-3xl mx-auto text-white">
    <h2 class="text-3xl font-bold mb-6">Add New Zone</h2>

    <form action="{{ route('zones.store') }}" method="POST" class="bg-[#1e1e1e] p-6 rounded-lg shadow-md space-y-5">
        @csrf

        <div>
            <label class="block mb-2 text-sm font-medium">Zone Name</label>
            <input type="text" name="name" required
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <select name="comfort_status"
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
            <label class="block mb-2 text-sm font-medium">Energy Usage (kWh)</label>
            <input type="text" name="energy_usage"
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Device Type</label>
            <select name="device_type"
                    class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
                <option value="Light">Light</option>
                <option value="HVAC">HVAC</option>
                <option value="Shade">Shade</option>
            </select>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="maintenance_alert" id="maintenance_alert"
                   class="rounded border-gray-600 text-green-500 focus:ring-green-500">
            <label for="maintenance_alert" class="text-sm">Maintenance Alert</label>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="device_control_status" id="device_control_status"
                   class="rounded border-gray-600 text-green-500 focus:ring-green-500">
            <label for="device_control_status" class="text-sm">Enable Device Control</label>
        </div>

        <div class="text-right">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-black font-semibold px-6 py-2 rounded transition-all shadow">
                Create Zone
            </button>
        </div>
    </form>
</div>
@endsection