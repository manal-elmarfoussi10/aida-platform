@extends('layouts.app')
@section('title', 'Add New Device')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold tracking-wide">Add New Device</h2>
        <a href="{{ route('devices.index') }}" class="text-sm text-green-400 hover:underline">← Back to Devices</a>
    </div>

    <form action="{{ route('devices.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Device Name --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Device Name</label>
            <input type="text" name="device_name" value="{{ old('device_name') }}"
                class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        {{-- Device Type --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Device Type</label>
            <input type="text" name="device_type" value="{{ old('device_type') }}"
                class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        {{-- Status --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Status</label>
            <select name="current_status"
                class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="1" {{ old('current_status') == 1 ? 'selected' : '' }}>On</option>
                <option value="0" {{ old('current_status') == 0 ? 'selected' : '' }}>Off</option>
            </select>
        </div>

        {{-- Site --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Site</label>
            <select id="siteSelect"
                class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="">Select Site</option>
                @foreach($sites as $site)
                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Building --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Building</label>
            <select id="buildingSelect"
                class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="">Select Building</option>
            </select>
        </div>

        {{-- Floor --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Floor</label>
            <select id="floorSelect"
                class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="">Select Floor</option>
            </select>
        </div>

        {{-- Zone --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Zone</label>
            <select name="zone_id" id="zoneSelect"
                class="w-full bg-gray-800 text-white border border-gray-600 rounded px-4 py-2">
                <option value="">Select Zone</option>
            </select>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="bg-green-500 text-black px-6 py-2 rounded hover:bg-green-400 transition-all">
            Save Device
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const siteSelect = document.getElementById('siteSelect');
    const buildingSelect = document.getElementById('buildingSelect');
    const floorSelect = document.getElementById('floorSelect');
    const zoneSelect = document.getElementById('zoneSelect');

    siteSelect.addEventListener('change', function () {
        const siteId = this.value;
        buildingSelect.innerHTML = '<option>Loading...</option>';
        floorSelect.innerHTML = '<option value="">Select Floor</option>';
        zoneSelect.innerHTML = '<option value="">Select Zone</option>';

        fetch(`/api/buildings/${siteId}`)
            .then(res => res.json())
            .then(data => {
                buildingSelect.innerHTML = '<option value="">Select Building</option>';
                data.forEach(building => {
                    buildingSelect.innerHTML += `<option value="${building.id}">${building.name}</option>`;
                });
            });
    });

    buildingSelect.addEventListener('change', function () {
        const buildingId = this.value;
        floorSelect.innerHTML = '<option>Loading...</option>';
        zoneSelect.innerHTML = '<option value="">Select Zone</option>';

        fetch(`/api/floors/${buildingId}`)
            .then(res => res.json())
            .then(data => {
                floorSelect.innerHTML = '<option value="">Select Floor</option>';
                data.forEach(floor => {
                    floorSelect.innerHTML += `<option value="${floor.id}">${floor.name}</option>`;
                });
            });
    });

    floorSelect.addEventListener('change', function () {
        const floorId = this.value;
        zoneSelect.innerHTML = '<option>Loading...</option>';

        fetch(`/api/zones/${floorId}`)
            .then(res => res.json())
            .then(data => {
                zoneSelect.innerHTML = '<option value="">Select Zone</option>';
                data.forEach(zone => {
                    zoneSelect.innerHTML += `<option value="${zone.id}">${zone.name}</option>`;
                });
            });
    });
</script>
@endpush