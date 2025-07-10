@extends('layouts.app')
@section('title', 'Edit Configuration')

@section('content')
<div class="p-6 text-white">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-3xl font-bold">Edit Configuration</h2>
        <a href="{{ route('configurations.index') }}"
           class="text-sm bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
            ← Back to Configurations
        </a>
    </div>

    <form action="{{ route('configurations.update', $configuration->id) }}" method="POST"
          class="bg-[#1e1e1e] p-6 rounded-lg shadow w-full max-w-4xl">
        @csrf
        @method('PUT')

        {{-- Site / Building / Floor / Zone --}}
        <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Site --}}
            <div>
                <label class="block mb-1 text-sm font-medium">Site</label>
                <select id="siteSelect" class="w-full bg-gray-800 text-white rounded px-3 py-2 border border-gray-600">
                    <option value="">-- Select Site --</option>
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Building --}}
            <div>
                <label class="block mb-1 text-sm font-medium">Building</label>
                <select id="buildingSelect" class="w-full bg-gray-800 text-white rounded px-3 py-2 border border-gray-600">
                    <option value="">-- Select Building --</option>
                </select>
            </div>

            {{-- Floor --}}
            <div>
                <label class="block mb-1 text-sm font-medium">Floor</label>
                <select id="floorSelect" class="w-full bg-gray-800 text-white rounded px-3 py-2 border border-gray-600">
                    <option value="">-- Select Floor --</option>
                </select>
            </div>

            {{-- Zone --}}
            <div>
                <label class="block mb-1 text-sm font-medium">Zone</label>
                <select name="zones[]" id="zoneSelect" required
                        class="w-full bg-gray-800 text-white rounded px-3 py-2 border border-gray-600">
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}"
                            {{ $configuration->zones->contains($zone->id) ? 'selected' : '' }}>
                            {{ $zone->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Name --}}
        <div class="mb-6">
            <label class="block mb-1 text-sm font-medium">Name</label>
            <input type="text" name="name" value="{{ $configuration->name }}" required
                   class="w-full px-4 py-2 bg-[#333333] text-white rounded focus:ring-2 focus:ring-green-400 focus:outline-none">
        </div>

        {{-- Type --}}
        <div class="mb-6">
            <label class="block mb-1 text-sm font-medium">Type</label>
            <div class="flex gap-6">
                @foreach(['Light' => 'lightbulb', 'HVAC' => 'snowflake', 'Shade' => 'blinds'] as $value => $icon)
                    <label class="flex items-center gap-2">
                        <input type="radio" name="type" value="{{ $value }}" {{ $configuration->type === $value ? 'checked' : '' }}>
                        <i data-lucide="{{ $icon }}" class="w-5 h-5"></i> {{ $value }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Mode --}}
        <div class="mb-6">
            <label class="block mb-1 text-sm font-medium">Mode</label>
            <div class="flex gap-6">
                @foreach(['Eco' => 'leaf', 'Performance' => 'zap', 'Standard' => 'gauge'] as $value => $icon)
                    <label class="flex items-center gap-2">
                        <input type="radio" name="mode" value="{{ $value }}" {{ $configuration->mode === $value ? 'checked' : '' }}>
                        <i data-lucide="{{ $icon }}" class="w-5 h-5"></i> {{ $value }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Submit --}}
        <div class="mt-6">
            <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-black font-semibold px-6 py-2 rounded shadow transition">
                Update Configuration
            </button>
        </div>
    </form>
</div>

{{-- Lucide --}}
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>

<script>
    const buildingSelect = document.getElementById('buildingSelect');
    const floorSelect = document.getElementById('floorSelect');
    const zoneSelect = document.getElementById('zoneSelect');

    document.getElementById('siteSelect').addEventListener('change', function () {
        fetch(`/zones-v2/site/${this.value}/buildings`)
            .then(res => res.json())
            .then(data => {
                buildingSelect.innerHTML = `<option value="">-- Select Building --</option>`;
                floorSelect.innerHTML = `<option value="">-- Select Floor --</option>`;
                zoneSelect.innerHTML = `<option value="">-- Select Zone --</option>`;
                data.forEach(building => {
                    buildingSelect.innerHTML += `<option value="${building.id}">${building.name}</option>`;
                });
            });
    });

    buildingSelect.addEventListener('change', function () {
        fetch(`/zones-v2/building/${this.value}/floors`)
            .then(res => res.json())
            .then(data => {
                floorSelect.innerHTML = `<option value="">-- Select Floor --</option>`;
                zoneSelect.innerHTML = `<option value="">-- Select Zone --</option>`;
                data.forEach(floor => {
                    floorSelect.innerHTML += `<option value="${floor.id}">${floor.name}</option>`;
                });
            });
    });

    floorSelect.addEventListener('change', function () {
        fetch(`/zones-v2/floor/${this.value}/zones`)
            .then(res => res.json())
            .then(data => {
                zoneSelect.innerHTML = `<option value="">-- Select Zone --</option>`;
                data.forEach(zone => {
                    zoneSelect.innerHTML += `<option value="${zone.id}">${zone.name}</option>`;
                });
            });
    });
</script>
@endsection