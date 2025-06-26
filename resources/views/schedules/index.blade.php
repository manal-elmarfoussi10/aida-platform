@extends('layouts.app')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Schedules List</h2>
        <a href="{{ route('schedules.create') }}" class="bg-green-500 text-black px-4 py-2 rounded">Add New Schedule</a>
    </div>

    <div class="bg-[#1e1e1e] rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-black">
                <tr>
                    <th class="px-4 py-3 font-semibold">Device</th>
                    <th class="px-4 py-3 font-semibold">Action</th>
                    <th class="px-4 py-3 font-semibold">Scheduled At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr class="border-b border-gray-700 hover:bg-[#2a2a2a]">
                        <td class="px-4 py-3">{{ $schedule->device->device_name ?? 'Unknown' }}</td>
                        <td class="px-4 py-3">{{ ucfirst($schedule->action) }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($schedule->scheduled_at)->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection