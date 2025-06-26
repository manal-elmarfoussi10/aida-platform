@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto text-white">
    <h2 class="text-3xl font-bold mb-6">Edit Device</h2>

    <form action="{{ route('devices.update', $device) }}" method="POST" class="space-y-6 bg-[#1f1f1f] p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm mb-1 font-semibold">Zone</label>
            <select name="zone" required
                    class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-green-400">
                <option value="" disabled>Select a zone</option>
                @foreach($zones as $zone)
                    <option value="{{ $zone->name }}" {{ $device->zone == $zone->name ? 'selected' : '' }}>
                        {{ $zone->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm mb-1 font-semibold">Device Type</label>
            <input type="text" name="device_type" value="{{ $device->device_type }}"
                   class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-green-400" required>
        </div>

        <div>
            <label class="block text-sm mb-1 font-semibold">Device Name</label>
            <input type="text" name="device_name" value="{{ $device->device_name }}"
                   class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-green-400" required>
        </div>

        <div class="flex items-center">
            <input type="checkbox" id="current_status" name="current_status"
                   class="mr-2 rounded text-green-500 focus:ring-green-400"
                   {{ $device->current_status ? 'checked' : '' }}>
            <label for="current_status" class="text-sm font-medium">Current Status</label>
        </div>

        <div class="flex items-center">
            <input type="checkbox" id="manual_control" name="manual_control"
                   class="mr-2 rounded text-green-500 focus:ring-green-400"
                   {{ $device->manual_control ? 'checked' : '' }}>
            <label for="manual_control" class="text-sm font-medium">Manual Control</label>
        </div>

        <div>
            <button type="submit"
                    class="bg-green-500 hover:bg-green-400 text-black px-6 py-2 rounded font-semibold shadow transition-all">
                Update Device
            </button>
        </div>
    </form>
</div>
@endsection