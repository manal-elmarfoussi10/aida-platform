@extends('layouts.app')
@section('title', 'Zones List')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold tracking-wide">Zones List</h2>
        <a href="{{ route('zones-v2.create') }}"
           class="bg-green-500 text-black px-5 py-2 rounded hover:bg-green-400 shadow-lg transition-all">
            Add New Zone
        </a>
    </div>

    <div class="relative w-1/3 mb-6">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i data-lucide="search" class="w-4 h-4"></i>
        </span>
        <input type="text" placeholder="Search zones..."
               class="h-10 text-sm pl-10 pr-4 py-2 w-full bg-gray-800 text-white border border-gray-600 rounded placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-400">
    </div>

    <div class="bg-[#1e1e1e] rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#2a2a2a] text-white">
                <tr>
                    <th class="px-4 py-3 font-semibold">Zone Name</th>
                    <th class="px-4 py-3 font-semibold">Zone Type</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Occupancy</th>
                    <th class="px-4 py-3 font-semibold">Temperature/Humidity</th>
                    <th class="px-4 py-3 font-semibold">Energy Usage</th>
                    <th class="px-4 py-3 font-semibold text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $zone)
                <tr class="border-b border-white hover:bg-[#2a2a2a] transition-all">
                    <td class="px-4 py-3">{{ $zone->name }}</td>
                    <td class="px-4 py-3">{{ $zone->zone_type }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <button
                                class="toggle-btn flex items-center w-20 h-8 px-2 rounded-full font-bold text-sm transition-all duration-300
                                    {{ $zone->status ? 'bg-green-500 text-black' : 'bg-gray-600 text-white' }}"
                                data-id="{{ $zone->id }}"
                                data-status="{{ $zone->status }}"
                            >
                                <span class="z-10">{{ $zone->status ? 'ON' : 'OFF' }}</span>
                                <div class="circle w-5 h-5 ml-auto rounded-full bg-white shadow transition-transform duration-300"
                                     style="{{ $zone->status ? 'transform: translateX(0)' : 'transform: translateX(-16px)' }}">
                                </div>
                            </button>
                        </div>
                    </td>
                    <td class="px-4 py-3">{{ $zone->occupancy ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $zone->temperature_humidity ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $zone->energy_usage ?? '-' }}</td>
                    <td class="px-4 py-3 text-center flex justify-center gap-3">
                        <a href="{{ route('zones-v2.edit', $zone) }}" class="text-green-400 hover:text-green-600">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form method="POST" action="{{ route('zones-v2.destroy', $zone) }}">
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
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.toggle-btn').forEach(button => {
        button.addEventListener('click', function () {
            const zoneId = this.dataset.id;
            const currentStatus = parseInt(this.dataset.status);
            const newStatus = currentStatus ? 0 : 1;
            const btn = this;

            fetch(`/zones-v2/${zoneId}/toggle`, {
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
                    btn.dataset.status = data.status;
                    btn.classList.toggle('bg-green-500', data.status == 1);
                    btn.classList.toggle('bg-gray-600', data.status == 0);
                    btn.classList.toggle('text-black', data.status == 1);
                    btn.classList.toggle('text-white', data.status == 0);

                    btn.querySelector('span').textContent = data.status ? 'ON' : 'OFF';
                    btn.querySelector('.circle').style.transform = data.status ? 'translateX(0)' : 'translateX(-16px)';
                } else {
                    alert('Failed to update status.');
                }
            });
        });
    });
</script>
@endpush