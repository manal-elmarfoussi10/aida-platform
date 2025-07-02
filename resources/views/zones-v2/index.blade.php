@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white">Zones List</h1>
        <a href="{{ route('zones-v2.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Add New Zone
        </a>
    </div>

    <div class="bg-gray-900 text-white rounded-lg overflow-hidden shadow-md">
        <table class="w-full text-left">
            <thead class="bg-gray-800">
                <tr>
                    <th class="py-3 px-4">Zone Name</th>
                    <th class="py-3 px-4">Zone Type</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Occupancy</th>
                    <th class="py-3 px-4">Temperature/Humidity</th>
                    <th class="py-3 px-4">Energy Consumption</th>
                    <th class="py-3 px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $zone)
                    <tr class="border-t border-gray-700">
                        <td class="py-3 px-4">{{ $zone->name }}</td>
                        <td class="py-3 px-4">{{ $zone->type }}</td>
                        <td class="py-3 px-4">
                            <button
                                class="flex items-center space-x-2 toggle-status {{ $zone->status ? 'text-green-400' : 'text-gray-400' }}"
                                data-id="{{ $zone->id }}"
                                data-status="{{ $zone->status }}">
                                <span class="text-sm font-semibold">{{ $zone->status ? 'ON' : 'OFF' }}</span>
                                <div class="w-10 h-5 rounded-full p-1 bg-gray-700 flex items-center {{ $zone->status ? 'justify-end bg-green-500' : 'justify-start' }}">
                                    <div class="w-4 h-4 bg-white rounded-full"></div>
                                </div>
                            </button>
                        </td>
                        <td class="py-3 px-4">{{ $zone->occupancy }}</td>
                        <td class="py-3 px-4">{{ $zone->temperature ?? '-' }}/{{ $zone->humidity ?? '-' }}</td>
                        <td class="py-3 px-4">{{ $zone->energy_usage }}kWh</td>
                        <td class="py-3 px-4 flex space-x-2">
                            <a href="{{ route('zones-v2.edit', $zone->id) }}" class="text-green-500 hover:text-green-700">
                                ✏️
                            </a>
                            <form action="{{ route('zones-v2.destroy', $zone->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', async function () {
            const zoneId = this.dataset.id;
            const currentStatus = parseInt(this.dataset.status);
            const newStatus = currentStatus ? 0 : 1;

            try {
                const response = await fetch(`/zones-v2/${zoneId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                if (!response.ok) throw new Error('Toggle failed');

                window.location.reload();
            } catch (error) {
                alert('Error toggling zone status');
            }
        });
    });
</script>
@endsection