@extends('layouts.app')
@section('title', 'Edit Device')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Edit Device</h2>
        <a href="{{ route('devices.index') }}" class="text-sm text-green-400 hover:underline">← Back to Devices</a>
    </div>

    <form action="{{ route('devices.update', $device) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Device Name --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Device Name</label>
            <input type="text" name="device_name" value="{{ old('device_name', $device->device_name) }}"
                   class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        {{-- Device Type --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Device Type</label>
            <input type="text" name="device_type" value="{{ old('device_type', $device->device_type) }}"
                   class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        {{-- Status --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Status</label>
            <select name="current_status" class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="1" {{ $device->current_status ? 'selected' : '' }}>On</option>
                <option value="0" {{ !$device->current_status ? 'selected' : '' }}>Off</option>
            </select>
        </div>

        {{-- Cascading Zone Selection --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Site</label>
            <select id="siteSelect" class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="">Select Site</option>
                @foreach($sites as $site)
                    <option value="{{ $site->id }}" {{ $device->zoneV2->floor->building->site->id == $site->id ? 'selected' : '' }}>
                        {{ $site->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Building</label>
            <select id="buildingSelect" class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="">Select Building</option>
                {{-- will be populated via JS --}}
            </select>
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Floor</label>
            <select id="floorSelect" class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="">Select Floor</option>
                {{-- will be populated via JS --}}
            </select>
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Zone</label>
            <select name="zone_id" id="zoneSelect" class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="">Select Zone</option>
                {{-- will be populated via JS --}}
            </select>
        </div>

        <button type="submit"
                class="bg-green-500 text-black px-6 py-2 rounded hover:bg-green-400 transition-all">
            Update Device
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const siteSelect = document.getElementById("siteSelect");
    const buildingSelect = document.getElementById("buildingSelect");
    const floorSelect = document.getElementById("floorSelect");
    const zoneSelect = document.getElementById("zoneSelect");

    const initialSiteId = "{{ $device->zoneV2->floor->building->site->id }}";
    const initialBuildingId = "{{ $device->zoneV2->floor->building->id }}";
    const initialFloorId = "{{ $device->zoneV2->floor->id }}";
    const initialZoneId = "{{ $device->zoneV2->id }}";

    function loadBuildings(siteId, selectedBuildingId = null) {
        fetch(`/api/buildings/${siteId}`)
            .then(res => res.json())
            .then(data => {
                buildingSelect.innerHTML = `<option value="">Select Building</option>`;
                data.forEach(b => {
                    const selected = b.id == selectedBuildingId ? 'selected' : '';
                    buildingSelect.innerHTML += `<option value="${b.id}" ${selected}>${b.name}</option>`;
                });
                if (selectedBuildingId) loadFloors(selectedBuildingId, initialFloorId);
            });
    }

    function loadFloors(buildingId, selectedFloorId = null) {
        fetch(`/api/floors/${buildingId}`)
            .then(res => res.json())
            .then(data => {
                floorSelect.innerHTML = `<option value="">Select Floor</option>`;
                data.forEach(f => {
                    const selected = f.id == selectedFloorId ? 'selected' : '';
                    floorSelect.innerHTML += `<option value="${f.id}" ${selected}>${f.name}</option>`;
                });
                if (selectedFloorId) loadZones(selectedFloorId, initialZoneId);
            });
    }

    function loadZones(floorId, selectedZoneId = null) {
        fetch(`/api/zones/${floorId}`)
            .then(res => res.json())
            .then(data => {
                zoneSelect.innerHTML = `<option value="">Select Zone</option>`;
                data.forEach(z => {
                    const selected = z.id == selectedZoneId ? 'selected' : '';
                    zoneSelect.innerHTML += `<option value="${z.id}" ${selected}>${z.name}</option>`;
                });
            });
    }

    siteSelect.addEventListener("change", () => {
        loadBuildings(siteSelect.value);
        floorSelect.innerHTML = `<option value="">Select Floor</option>`;
        zoneSelect.innerHTML = `<option value="">Select Zone</option>`;
    });

    buildingSelect.addEventListener("change", () => {
        loadFloors(buildingSelect.value);
        zoneSelect.innerHTML = `<option value="">Select Zone</option>`;
    });

    floorSelect.addEventListener("change", () => {
        loadZones(floorSelect.value);
    });

    // initial population
    if (initialSiteId) loadBuildings(initialSiteId, initialBuildingId);
});
</script>
@endpush