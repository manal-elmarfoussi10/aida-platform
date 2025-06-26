@extends('layouts.app')
@section('title', 'Add New Schedule')

@section('content')
<div class="p-8 max-w-3xl mx-auto text-white">
    <h2 class="text-3xl font-bold mb-6">Add New Schedule</h2>

    <form action="{{ route('schedules.store') }}" method="POST" class="bg-[#1e1e1e] p-6 rounded-lg shadow-md space-y-5">
        @csrf

        <div>
            <label class="block mb-2 text-sm font-medium">Action</label>
            <input type="text" name="action" required
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500"
                   placeholder="e.g. Turn off lights">
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Scheduled Time</label>
            <input type="datetime-local" name="scheduled_time" required
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Day</label>
            <select name="day" required
                    class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
                <option value="">Select Day</option>
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Device</label>
            <select name="device_id" required
                    class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
                <option value="">Select Device</option>
                @foreach($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->device_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-black font-semibold px-6 py-2 rounded transition-all shadow">
                Create Schedule
            </button>
        </div>
    </form>
</div>
@endsection