@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Device Control</h1>
    <a href="{{ route('devices.create') }}" class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-400">Add New Device</a>
</div>

<div class="relative w-1/3 mb-4">
    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
        <i data-lucide="search" class="w-4 h-4"></i>
    </span>
    <input type="text" placeholder="Search"
           class="h-10 text-sm pl-10 pr-4 py-2 w-full bg-white text-black border border-gray-300 rounded placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400">
</div>

<div class="bg-[#1f1f1f] rounded shadow overflow-x-auto">
    <table class="w-full text-sm text-left text-white">
        <thead class="bg-white text-black">
            <tr>
                <th class="px-4 py-3">Zone</th>
                <th class="px-4 py-3">Device Type</th>
                <th class="px-4 py-3">Device Name</th>
                <th class="px-4 py-3">Current Status</th>
                <th class="px-4 py-3">Last Updated</th>
                <th class="px-4 py-3">Manual Control</th>
                <th class="px-4 py-3 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($devices as $device)
            <tr class="border-b border-gray-700 hover:bg-[#2a2a2a]">
                <td class="px-4 py-3">{{ $device->zone }}</td>
                <td class="px-4 py-3">{{ $device->device_type }}</td>
                <td class="px-4 py-3">{{ $device->device_name }}</td>
                <td class="px-4 py-3">
                    <button class="toggle-status px-3 py-1 rounded text-xs {{ $device->current_status ? 'bg-green-500' : 'bg-gray-600' }}" data-id="{{ $device->id }}">
                        {{ $device->current_status ? 'ON' : 'OFF' }}
                    </button>
                </td>
                <td class="px-4 py-3">{{ $device->updated_at->format('Y-m-d H:i') }}</td>
                <td class="px-4 py-3">
                    <button class="toggle-manual px-3 py-1 rounded text-xs {{ $device->manual_control ? 'bg-green-500' : 'bg-gray-600' }}" data-id="{{ $device->id }}">
                        {{ $device->manual_control ? 'ON' : 'OFF' }}
                    </button>
                </td>
                <td class="px-4 py-3 text-center flex justify-center gap-3">
                    <a href="{{ route('devices.edit', $device) }}" class="text-green-400 hover:text-green-600">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </a>
                    <form action="{{ route('devices.destroy', $device) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
document.querySelectorAll('.toggle-status').forEach(button => {
    button.addEventListener('click', function () {
        fetch(`/devices/${this.dataset.id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(() => location.reload());
    });
});

document.querySelectorAll('.toggle-manual').forEach(button => {
    button.addEventListener('click', function () {
        fetch(`/devices/${this.dataset.id}/toggle-manual`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(() => location.reload());
    });
});
</script>
@endsection
