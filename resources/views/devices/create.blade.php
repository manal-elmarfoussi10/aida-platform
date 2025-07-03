@extends('layouts.app')
@section('title', 'Add New Device')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold tracking-wide">Add New Device</h2>
        <a href="{{ route('devices.index') }}" class="text-sm text-green-400 hover:underline">← Back to Devices</a>
    </div>

    <form action="{{ route('devices.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block mb-1 text-sm font-medium">Device Name</label>
            <input type="text" name="device_name" value="{{ old('device_name') }}"
                   class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Device Type</label>
            <input type="text" name="device_type" value="{{ old('device_type') }}"
                   class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Status</label>
            <select name="current_status"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="1" {{ old('current_status') == 1 ? 'selected' : '' }}>On</option>
                <option value="0" {{ old('current_status') == 0 ? 'selected' : '' }}>Off</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Zone</label>
            <select name="zone_id"
                    class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                        {{ $zone->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit"
                class="bg-green-500 text-black px-6 py-2 rounded hover:bg-green-400 transition-all">
            Save Device
        </button>
    </form>
</div>
@endsection