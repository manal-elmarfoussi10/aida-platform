@extends('layouts.app')
@section('title', 'Zones List')

@section('content')
<div class="p-6 text-white">
    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600 text-black rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header + Buttons --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold tracking-wide">Zones List</h2>

        <div class="flex gap-4">
            <a href="{{ route('zones-v2.create') }}"
               class="bg-green-500 text-black px-5 py-2 rounded hover:bg-green-400 shadow-lg transition-all">
                Add New Zone
            </a>

            <form action="{{ route('zones-v2.import') }}" method="POST" enctype="multipart/form-data" class="flex gap-2">
                @csrf
                <input type="file" name="csv_file" required
                       class="text-sm text-white file:bg-green-500 file:text-black file:px-4 file:py-1 file:rounded file:shadow-sm" />
                <button type="submit"
                        class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-400 shadow-lg transition-all">
                    Upload CSV
                </button>
            </form>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('zones-v2.index') }}" class="flex gap-4 mb-6">
        <select name="site_id" id="site_id" class="bg-gray-800 text-white border border-gray-600 px-4 py-2 rounded"
                onchange="this.form.submit()">
            <option value="">-- Select Site --</option>
            @foreach ($sites as $site)
                <option value="{{ $site->id }}" {{ $site->id == $selectedSiteId ? 'selected' : '' }}>
                    {{ $site->name }}
                </option>
            @endforeach
        </select>

        <select name="building_id" id="building_id" class="bg-gray-800 text-white border border-gray-600 px-4 py-2 rounded"
                onchange="this.form.submit()">
            <option value="">-- Select Building --</option>
            @foreach ($buildings as $building)
                <option value="{{ $building->id }}" {{ $building->id == $selectedBuildingId ? 'selected' : '' }}>
                    {{ $building->name }}
                </option>
            @endforeach
        </select>

        <select name="floor_id" id="floor_id" class="bg-gray-800 text-white border border-gray-600 px-4 py-2 rounded"
                onchange="this.form.submit()">
            <option value="">-- Select Floor --</option>
            @foreach ($floors as $floor)
                <option value="{{ $floor->id }}" {{ $floor->id == $selectedFloorId ? 'selected' : '' }}>
                    {{ $floor->name }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- Search Bar --}}
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
                @forelse ($zones as $zone)
                <tr class="border-b border-white hover:bg-[#2a2a2a] transition-all">
                    <td class="px-4 py-3">{{ $zone->name }}</td>
                    <td class="px-4 py-3">{{ $zone->zone_type }}</td>
                    <td class="px-4 py-3">
                        <livewire:toggle-button :zone="$zone" :key="$zone->id" />
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
                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">No zones available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
@livewireScripts
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    });
</script>
@endpush
