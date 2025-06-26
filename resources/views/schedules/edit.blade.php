@extends('layouts.app')
@section('title', 'Edit Schedule')

@section('content')
<div class="p-6 text-white max-w-xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Edit Schedule</h2>

    <form action="{{ route('schedules.update', $schedule) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Select Device --}}
        <div>
            <label class="block mb-1 text-sm">Select Device</label>
            <select name="device_id" class="w-full p-2 bg-gray-800 border border-gray-600 rounded" required>
                @foreach($devices as $device)
                    <option value="{{ $device->id }}" {{ $schedule->device_id == $device->id ? 'selected' : '' }}>
                        {{ $device->device_name }} ({{ $device->zone->name }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Action --}}
        <div>
            <label class="block mb-1 text-sm">Action</label>
            <select name="action" class="w-full p-2 bg-gray-800 border border-gray-600 rounded" required>
                <option value="on" {{ $schedule->action === 'on' ? 'selected' : '' }}>Turn ON</option>
                <option value="off" {{ $schedule->action === 'off' ? 'selected' : '' }}>Turn OFF</option>
            </select>
        </div>

        {{-- Date & Time --}}
        <div>
            <label class="block mb-1 text-sm">Schedule Time</label>
            <input type="datetime-local" name="scheduled_at"
                   value="{{ \Carbon\Carbon::parse($schedule->scheduled_at)->format('Y-m-d\TH:i') }}"
                   class="w-full p-2 bg-gray-800 border border-gray-600 rounded text-white" required>
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded shadow">
            Update Schedule
        </button>
    </form>
</div>
@endsection