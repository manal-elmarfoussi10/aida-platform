@extends('layouts.app')
@section('title', 'Edit Zone')

@section('content')
<div class="p-8 max-w-3xl mx-auto text-white">
    <h2 class="text-3xl font-bold mb-6">Edit Zone</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-800 text-red-100 p-3 rounded shadow">
            <strong>Error:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('zones-v2.update', $zone->id) }}" method="POST" class="bg-[#1e1e1e] p-6 rounded-lg shadow-md space-y-5">
        @csrf
        @method('PUT')

        {{-- Site --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Site</label>
            <select id="siteSelect" class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded" required>
                <option value="">Select Site</option>
                @foreach ($sites as $site)
                    <option value="{{ $site->id }}"
                        {{ $zone->floor->building->site_id == $site->id ? 'selected' : '' }}>
                        {{ $site->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Building --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Building</label>
            <select id="buildingSelect" class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded" required>
                <option value="">Select Building</option>
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}"
                        {{ $zone->floor->building_id == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Floor --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Floor</label>
            <select name="floor_id" id="floorSelect" class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded" required>
                <option value="">Select Floor</option>
                @foreach ($floors as $floor)
                    <option value="{{ $floor->id }}"
                        {{ $zone->floor_id == $floor->id ? 'selected' : '' }}>
                        {{ $floor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Zone Name --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Zone Name</label>
            <input type="text" name="name" value="{{ old('name', $zone->name) }}" required
                class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-green-500">
        </div>

        {{-- Zone Type --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Zone Type</label>
            <select name="zone_type" required
                class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-green-500">
                <option value="">Select Type</option>
                <option value="HVAC" {{ $zone->zone_type == 'HVAC' ? 'selected' : '' }}>HVAC</option>
                <option value="Lighting" {{ $zone->zone_type == 'Lighting' ? 'selected' : '' }}>Lighting</option>
                <option value="Shade" {{ $zone->zone_type == 'Shade' ? 'selected' : '' }}>Shade</option>
            </select>
        </div>

        {{-- Occupancy --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Occupancy</label>
            <input type="number" name="occupancy" value="{{ old('occupancy', $zone->occupancy) }}"
                class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-green-500">
        </div>

        {{-- Temperature / Humidity --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Temperature / Humidity</label>
            <input type="text" name="temperature_humidity" value="{{ old('temperature_humidity', $zone->temperature_humidity) }}"
                class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-green-500">
        </div>

        {{-- Energy Usage --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Energy Usage (kWh)</label>
            <input type="text" name="energy_usage" value="{{ old('energy_usage', $zone->energy_usage) }}"
                class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-green-500">
        </div>

        {{-- Status --}}
        <div class="flex items-center mt-4">
            <input type="hidden" name="status" value="0">
            <input type="checkbox" name="status" value="1" id="status"
                {{ $zone->status ? 'checked' : '' }}
                class="mr-2 w-5 h-5 text-green-500 bg-gray-700 border-gray-600 rounded focus:ring-green-600">
            <label for="status" class="text-white">Zone Active (ON)</label>
        </div>

        {{-- Submit --}}
        <div class="text-right">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-black font-semibold px-6 py-2 rounded transition-all shadow">
                Update Zone
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const siteSelect = document.getElementById('siteSelect');
    const buildingSelect = document.getElementById('buildingSelect');
    const floorSelect = document.getElementById('floorSelect');

    siteSelect.addEventListener('change', async function () {
        const siteId = this.value;
        buildingSelect.innerHTML = '<option>Loading...</option>';
        floorSelect.innerHTML = '<option>Select Floor</option>';

        const res = await fetch(`/api/buildings/${siteId}`);
        const buildings = await res.json();

        buildingSelect.innerHTML = '<option value="">Select Building</option>';
        buildings.forEach(b => {
            const option = document.createElement('option');
            option.value = b.id;
            option.textContent = b.name;
            buildingSelect.appendChild(option);
        });
    });

    buildingSelect.addEventListener('change', async function () {
        const buildingId = this.value;
        floorSelect.innerHTML = '<option>Loading...</option>';

        const res = await fetch(`/api/floors/${buildingId}`);
        const floors = await res.json();

        floorSelect.innerHTML = '<option value="">Select Floor</option>';
        floors.forEach(f => {
            const option = document.createElement('option');
            option.value = f.id;
            option.textContent = f.name;
            floorSelect.appendChild(option);
        });
    });
</script>
@endpush