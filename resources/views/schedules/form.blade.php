@extends('layouts.app')
@section('title', 'Add Schedule')

@section('content')
<div class="p-6 text-white max-w-xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Add New Schedule</h2>

    <form action="{{ route('schedules.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1">Select Device</label>
            <select name="device_id" class="w-full bg-gray-800 text-white p-2 rounded border border-gray-600">
                @foreach ($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->device_name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1">Action</label>
            <select name="action" class="w-full bg-gray-800 text-white p-2 rounded border border-gray-600">
                <option value="on">Turn ON</option>
                <option value="off">Turn OFF</option>
            </select>
        </div>

        <div>
            <label class="block mb-1">Time</label>
            <input type="time" name="scheduled_time" required class="w-full bg-gray-800 text-white p-2 rounded border border-gray-600">
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded text-black">
            Save Schedule
        </button>
    </form>
</div>
@endsection