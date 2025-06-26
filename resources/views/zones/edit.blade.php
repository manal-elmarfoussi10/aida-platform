@extends('layouts.app')
@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Zone</h2>
    <form action="{{ route('zones.update', $zone) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label>Name</label>
            <input name="name" value="{{ $zone->name }}" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label>Comfort Status</label>
            <input name="comfort_status" value="{{ $zone->comfort_status }}" class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label>Energy Usage</label>
            <input name="energy_usage" value="{{ $zone->energy_usage }}" class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label>Device Type</label>
            <select name="device_type" class="w-full p-2 border rounded">
                <option {{ $zone->device_type == 'Light' ? 'selected' : '' }}>Light</option>
                <option {{ $zone->device_type == 'HVAC' ? 'selected' : '' }}>HVAC</option>
                <option {{ $zone->device_type == 'Shade' ? 'selected' : '' }}>Shade</option>
            </select>
        </div>
        <div class="mb-4">
            <label>Maintenance Alert test</label>
            <input type="checkbox" name="maintenance_alert" {{ $zone->maintenance_alert ? 'checked' : '' }}>
        </div>
        <div class="mb-4">
            <label>Device Control Status</label>
            <input type="checkbox" name="device_control_status" {{ $zone->device_control_status ? 'checked' : '' }}>
        </div>
        <button class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
