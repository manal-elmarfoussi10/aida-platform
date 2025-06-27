@extends('layouts.app')
@section('title', 'Zones List')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold tracking-wide">Zones List</h2>
        <a href="{{ route('zones.create') }}"
           class="bg-green-500 text-black px-5 py-2 rounded hover:bg-green-400 shadow-lg transition-all">
            Add New Zone
        </a>
    </div>

    {{-- Search bar --}}
    <div class="relative w-1/3 mb-6">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i data-lucide="search" class="w-4 h-4"></i>
        </span>
        <input type="text" placeholder="Search zones..."
               class="h-10 text-sm pl-10 pr-4 py-2 w-full bg-gray-800 text-white border border-gray-600 rounded placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-400">
    </div>

    {{-- Table --}}
    <div class="bg-[#1e1e1e] rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-black">
                <tr>
                    <th class="px-4 py-3 font-semibold">Zone Name</th>
                    <th class="px-4 py-3 font-semibold">Comfort Status</th>
                    <th class="px-4 py-3 font-semibold">Energy Usage</th>
                    <th class="px-4 py-3 font-semibold">Device Type</th>
                    <th class="px-4 py-3 font-semibold">Maintenance Alert</th>
                    <th class="px-4 py-3 font-semibold">Device Control</th>
                    <th class="px-4 py-3 font-semibold text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $zone)
                <tr class="border-b border-gray-700 hover:bg-[#2a2a2a]">
                    <td class="px-4 py-3">{{ $zone->name }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full
                                     {{ $zone->comfort_status === 'Comfortable' ? 'bg-green-500 text-black' : 'bg-yellow-500 text-black' }}">
                            {{ $zone->comfort_status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $zone->energy_usage }} kWh</td>
                    <td class="px-4 py-3">{{ $zone->device_type }}</td>
                    <td class="px-4 py-3">
                        @if ($zone->maintenance_alert)
                            <span class="text-yellow-400 flex items-center gap-1"><i class="text-xl">⚠️</i> Needs Attention</span>
                        @else
                            <span class="text-green-400 flex items-center gap-1"><i class="text-xl">✔️</i> Normal</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <button
                            data-id="{{ $zone->id }}"
                            data-status="{{ $zone->device_control_status ? 1 : 0 }}"
                            class="toggle-switch flex items-center justify-between w-20 h-8 px-2 rounded-full font-bold text-sm transition-all duration-300
                                {{ $zone->device_control_status ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                            <span class="z-10">{{ $zone->device_control_status ? 'ON' : 'OFF' }}</span>
                            <div class="circle w-5 h-5 rounded-full bg-white shadow transition-transform duration-300"
                                 style="{{ $zone->device_control_status ? 'transform: translateX(0)' : 'transform: translateX(24px)' }}">
                            </div>
                        </button>
                    </td>
                    <td class="px-4 py-3 text-center flex justify-center gap-3">
                        <a href="{{ route('zones.edit', $zone) }}" class="text-green-400 hover:text-green-600">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form method="POST" action="{{ route('zones.destroy', $zone) }}">
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
</div>

{{-- Toggle JavaScript --}}
<script>
    document.querySelectorAll('.toggle-switch').forEach(button => {
        button.addEventListener('click', function () {
            const zoneId = this.dataset.id;
            const currentStatus = parseInt(this.dataset.status);
            const newStatus = currentStatus === 1 ? 0 : 1;
            const btn = this;

            fetch(`/zones/${zoneId}/toggle-control`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    btn.dataset.status = data.newStatus;

                    btn.classList.toggle('bg-green-500', data.newStatus);
                    btn.classList.toggle('bg-red-500', !data.newStatus);

                    const label = btn.querySelector('span');
                    const circle = btn.querySelector('.circle');

                    label.textContent = data.newStatus ? 'ON' : 'OFF';
                    circle.style.transform = data.newStatus ? 'translateX(0)' : 'translateX(24px)';
                } else {
                    alert('Failed to update status.');
                }
            });
        });
    });
</script>
@endsection
