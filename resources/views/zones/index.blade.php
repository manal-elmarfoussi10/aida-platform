@extends('layouts.app')
@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Zones List</h2>
        <a href="{{ route('zones.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Add New Zone</a>
    </div>

    <input type="text" placeholder="Search" class="mb-4 px-3 py-2 rounded w-1/3">

    <table class="w-full text-left bg-white text-black rounded">
        <thead>
            <tr>
                <th>Zone Name</th>
                <th>Comfort Status</th>
                <th>Energy Usage</th>
                <th>Device Type</th>
                <th>Maintenance Alert</th>
                <th>Device Controls</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($zones as $zone)
            <tr class="border-t">
                <td>{{ $zone->name }}</td>
                <td>{{ $zone->comfort_status }}</td>
                <td>{{ $zone->energy_usage }}</td>
                <td>{{ $zone->device_type }}</td>
                <td>{{ $zone->maintenance_alert ? '⚠️' : '✔️' }}</td>
                <td>
                    <form method="POST" action="{{ route('zones.update', $zone) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="device_control_status" value="{{ !$zone->device_control_status }}">
                        <button class="text-xs px-2 py-1 bg-green-500 text-white rounded">
                            {{ $zone->device_control_status ? 'ON' : 'OFF' }}
                        </button>
                    </form>
                </td>
                <td>
                    <a href="{{ route('zones.edit', $zone) }}" class="text-green-500">✏️</a>
                    <form method="POST" action="{{ route('zones.destroy', $zone) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 ml-2">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
