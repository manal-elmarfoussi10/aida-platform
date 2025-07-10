@extends('layouts.app')
@section('title', 'Add New Zone')

@section('content')
<div class="p-8 max-w-3xl mx-auto text-white">
    <h2 class="text-3xl font-bold mb-6">Add New Zone</h2>

    {{-- Success message --}}
    @if (session('success'))
        <div class="mb-4 bg-green-800 text-green-100 p-3 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error messages --}}
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

    {{-- Zone Create Form --}}
    <form action="{{ route('zones-v2.store') }}" method="POST" class="bg-[#1e1e1e] p-6 rounded-lg shadow-md space-y-5">
        @csrf

        {{-- Select Site --}}
        <div>
            <label for="site_id" class="block mb-2 text-sm font-medium">Select Site</label>
            <select name="site_id" id="site_id" required
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
                <option value="">-- Select Site --</option>
                @foreach ($sites as $site)
                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Select Building --}}
        <div>
            <label for="building_id" class="block mb-2 text-sm font-medium">Select Building</label>
            <select name="building_id" id="building_id" required
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
                <option value="">-- Select Building --</option>
            </select>
        </div>

        {{-- Select Floor --}}
        <div>
            <label for="floor_id" class="block mb-2 text-sm font-medium">Select Floor</label>
            <select name="floor_id" id="floor_id" required
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
                <option value="">-- Select Floor --</option>
            </select>
        </div>

        {{-- Zone Name --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Zone Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500"
                placeholder="e.g. Zone A">
        </div>

        {{-- Zone Type --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Zone Type</label>
            <select name="zone_type" required
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
                <option value="">Select type</option>
                <option value="HVAC" {{ old('zone_type') == 'HVAC' ? 'selected' : '' }}>HVAC</option>
                <option value="Lighting" {{ old('zone_type') == 'Lighting' ? 'selected' : '' }}>Lighting</option>
                <option value="Shade" {{ old('zone_type') == 'Shade' ? 'selected' : '' }}>Shade</option>
            </select>
        </div>

        {{-- Occupancy --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Occupancy</label>
            <input type="number" name="occupancy" value="{{ old('occupancy') }}"
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500"
                placeholder="e.g. 5">
        </div>

        {{-- Temperature / Humidity --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Temperature / Humidity</label>
            <input type="text" name="temperature_humidity" value="{{ old('temperature_humidity') }}"
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500"
                placeholder="e.g. 22°C / 60%">
        </div>

        {{-- Energy Usage --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Energy Usage (kWh)</label>
            <input type="text" name="energy_usage" value="{{ old('energy_usage') }}"
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500"
                placeholder="e.g. 120">
        </div>

        {{-- Status --}}
        <div class="flex items-center mt-4">
            <input type="hidden" name="status" value="0">
            <input type="checkbox" name="status" value="1" id="status"
                class="mr-2 w-5 h-5 text-green-500 bg-gray-700 border-gray-600 rounded focus:ring-green-600">
            <label for="status" class="text-white">Zone Active (ON)</label>
        </div>

        {{-- Submit --}}
        <div class="text-right">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-black font-semibold px-6 py-2 rounded transition-all shadow">
                Create Zone
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const siteSelect = document.getElementById('site_id');
        const buildingSelect = document.getElementById('building_id');
        const floorSelect = document.getElementById('floor_id');

        siteSelect.addEventListener('change', function () {
            const siteId = this.value;
            buildingSelect.innerHTML = '<option value="">-- Select Building --</option>';
            floorSelect.innerHTML = '<option value="">-- Select Floor --</option>';

            if (siteId) {
                fetch(`/get-buildings/${siteId}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(building => {
                            const opt = document.createElement('option');
                            opt.value = building.id;
                            opt.textContent = building.name;
                            buildingSelect.appendChild(opt);
                        });
                    });
            }
        });

        buildingSelect.addEventListener('change', function () {
            const buildingId = this.value;
            floorSelect.innerHTML = '<option value="">-- Select Floor --</option>';

            if (buildingId) {
                fetch(`/get-floors/${buildingId}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(floor => {
                            const opt = document.createElement('option');
                            opt.value = floor.id;
                            opt.textContent = floor.name;
                            floorSelect.appendChild(opt);
                        });
                    });
            }
        });
    });
</script>
@endpush