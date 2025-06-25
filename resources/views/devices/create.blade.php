@extends('layouts.app')

@section('content')
<div class="bg-gray-900 min-h-screen text-white p-6">
    <div class="max-w-xl mx-auto">
        <h2 class="text-xl font-bold mb-6">Add New Device</h2>

        <form action="{{ route('devices.store') }}" method="POST" class="space-y-4">
            @csrf

            <input type="text" name="zone" placeholder="Zone" required class="w-full p-2 rounded bg-gray-800 border border-gray-600">
            <input type="text" name="device_type" placeholder="Device Type" required class="w-full p-2 rounded bg-gray-800 border border-gray-600">
            <input type="text" name="device_name" placeholder="Device Name" required class="w-full p-2 rounded bg-gray-800 border border-gray-600">

            <div class="flex items-center space-x-2">
                <input type="checkbox" id="current_status" name="current_status">
                <label for="current_status">Current Status</label>
            </div>
            <div class="flex items-center space-x-2">
                <input type="checkbox" id="manual_control" name="manual_control">
                <label for="manual_control">Manual Control</label>
            </div>

            <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded">Save Device</button>
        </form>
    </div>
</div>
@endsection