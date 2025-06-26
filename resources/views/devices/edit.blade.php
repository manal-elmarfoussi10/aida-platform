@extends('layouts.app')

@section('content')
<div class="bg-gray-900 min-h-screen text-white p-6">
    <div class="max-w-xl mx-auto">
        <h2 class="text-xl font-bold mb-6">Edit Device</h2>

        <form action="{{ route('devices.update', $device) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <input type="text" name="zone" value="{{ $device->zone }}" required class="w-full p-2 rounded bg-gray-800 border border-gray-600">
            <input type="text" name="device_type" value="{{ $device->device_type }}" required class="w-full p-2 rounded bg-gray-800 border border-gray-600">
            <input type="text" name="device_name" value="{{ $device->device_name }}" required class="w-full p-2 rounded bg-gray-800 border border-gray-600">

            <div class="flex items-center space-x-2">
                <input type="checkbox" id="current_status" name="current_status" {{ $device->current_status ? 'checked' : '' }}>
                <label for="current_status">Current Status</label>
            </div>
            <div class="flex items-center space-x-2">
                <input type="checkbox" id="manual_control" name="manual_control" {{ $device->manual_control ? 'checked' : '' }}>
                <label for="manual_control">Manual Control</label>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">Update Device</button>
        </form>
    </div>
</div>
@endsection