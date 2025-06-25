@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Add New Zone</h2>

    <form action="{{ route('zones.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Zone Name</label>
            <input type="text" name="name" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Comfort Status</label>
            <input type="text" name="comfort_status" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Energy Usage</label>
            <input type="text" name="energy_usage" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Device Type</label>
            <select name="device_type" class="w-full p-2 border rounded">
                <option value="Light">Light</option>
                <option value="HVAC">HVAC</option>
                <option value="Shade">Shade</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Maintenance Alert</label>
            <input type="checkbox" name="maintenance_alert">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Device Control Status</label>
            <input type="checkbox" name="device_control_status">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create Zone</button>
    </form>
</div>
@endsection