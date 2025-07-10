@extends('layouts.app')
@section('title', 'Sites & Hierarchy')

@section('content')
<div class="p-6 text-white">
    {{-- Page Header --}}
    <h2 class="text-4xl font-bold mb-2">Sites & Hierarchy</h2>
    <p class="text-gray-400 mb-6">Navigate through the site hierarchy using breadcrumbs and card selection.</p>

    {{-- Site and Building Dropdowns --}}
    <form method="GET" action="{{ route('hierarchy.index') }}" class="flex gap-6 mb-6">
        <div class="w-1/4">
            <label for="site_id" class="block mb-2 text-sm font-medium text-white">Select Site</label>
            <select name="site_id" id="site_id"
                class="w-full bg-transparent border border-gray-600 text-white p-2 rounded"
                onchange="this.form.submit()">
                @foreach($sites as $site)
                <option value="{{ $site->id }}" {{ $site->id == $selectedSiteId ? 'selected' : '' }}>
                    {{ $site->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="w-1/4">
            <label for="building_id" class="block mb-2 text-sm font-medium text-white">Select Building</label>
            <select name="building_id" id="building_id"
                class="w-full bg-transparent border border-gray-600 text-white p-2 rounded"
                onchange="this.form.submit()">
                @foreach($buildings as $building)
                <option value="{{ $building->id }}" {{ $building->id == $selectedBuildingId ? 'selected' : '' }}>
                    {{ $building->name }}
                </option>
                @endforeach
            </select>
        </div>
    </form>

    {{-- Breadcrumb Navigation --}}
    <div class="flex items-center text-gray-300 mb-6 text-sm">
        @if($selectedSiteId)
        <i class="mr-1" data-lucide="map-pin"></i>
        <span class="mr-2">{{ $sites->find($selectedSiteId)?->name }}</span>
        @endif

        @if($selectedBuildingId)
        <span class="mx-2">&gt;</span>
        <i class="mr-1" data-lucide="building-2"></i>
        <a href="#" class="text-blue-500">{{ $buildings->find($selectedBuildingId)?->name }}</a>
        @endif

        @if($selectedFloorId)
        <span class="mx-2">&gt;</span>
        <i class="mr-1" data-lucide="layers"></i>
        <a href="#" class="text-blue-500">{{ $floors->find($selectedFloorId)?->name }}</a>
        @endif
    </div>

    {{-- Floors --}}
    @if($floors->count())
    <h3 class="text-2xl font-semibold mb-4">Floors in {{ $buildings->find($selectedBuildingId)?->name }}</h3>
    <div class="flex flex-wrap gap-6 mb-10">
        @foreach($floors as $floor)
        <a href="{{ route('hierarchy.index', ['site_id' => $selectedSiteId, 'building_id' => $selectedBuildingId, 'floor_id' => $floor->id]) }}"
            class="w-1/4 border border-white bg-black/30 backdrop-blur-sm rounded-lg p-5 hover:bg-black/50 transition-all">
            <div class="flex items-center gap-3">
                <i class="w-6 h-6" data-lucide="layers"></i>
                <div>
                    <h4 class="text-lg font-semibold">{{ $floor->name }}</h4>
                    <span class="text-xs text-green-400">active</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    {{-- Zones --}}
    @if($selectedFloorId && $zones->count())
    <h3 class="text-2xl font-semibold mb-4">Zones on {{ $floors->find($selectedFloorId)?->name }}</h3>
    <div class="flex flex-wrap gap-6">
        @foreach($zones as $zone)
        <div class="w-1/4 bg-black/30 border border-gray-600 rounded-lg p-5 backdrop-blur-sm hover:bg-black/50 transition-all">
            <div class="flex items-center gap-3 mb-2">
                <i class="w-6 h-6" data-lucide="door-open"></i>
                <div>
                    <h4 class="text-lg font-semibold">{{ $zone->name }}</h4>
                    <span class="text-xs text-green-400">active</span>
                </div>
                @if($zone->devices_count)
                <span class="ml-auto bg-green-500 text-black text-xs font-bold px-2 py-1 rounded-full">
                    {{ $zone->devices_count }}
                </span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (window.lucide) window.lucide.createIcons();
    });
</script>
@endpush