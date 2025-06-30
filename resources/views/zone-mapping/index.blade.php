@extends('layouts.app')
@section('title', 'Zone Mapping')

@section('content')
<div class="px-8 py-8 text-white max-w-screen-xl mx-auto space-y-6">

    <!-- Header + Filters + Export -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <h2 class="text-3xl font-bold tracking-tight flex items-center gap-2">
            <i data-lucide="map-pin" class="w-6 h-6 text-green-400"></i> Zone Mapping
        </h2>

        <div class="flex gap-4 items-center">
            <form method="GET" action="{{ route('map-zones.index') }}" class="flex gap-2">
                <select name="type" onchange="this.form.submit()"
                    class="bg-[#333333] border border-gray-600 text-sm rounded px-4 py-2 text-white">
                    <option value="">All Types</option>
                    @foreach($devices->pluck('device_type')->unique() as $t)
                        <option value="{{ $t }}" {{ $type == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>

                <select name="zone" onchange="this.form.submit()"
                    class="bg-[#333333] border border-gray-600 text-sm rounded px-4 py-2 text-white">
                    <option value="">All Zones</option>
                    @foreach($zones as $z)
                        <option value="{{ $z->name }}" {{ $zone == $z->name ? 'selected' : '' }}>{{ $z->name }}</option>
                    @endforeach
                </select>
            </form>

            <form method="GET" action="{{ route('map-zones.export') }}">
                <input type="hidden" name="type" value="{{ request('type') }}">
                <input type="hidden" name="zone" value="{{ request('zone') }}">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-black text-sm px-4 py-2 rounded shadow">
                    Export CSV
                </button>
            </form>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-600 text-white p-3 rounded shadow text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Device Form -->
    <!-- Form -->

    <form action="{{ route('map-zones.update') }}" method="POST">
        @csrf

        <div class="bg-[#181818] rounded-xl shadow-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[#292929] text-with-300 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-2">
                                <i data-lucide="cpu" class="w-4 h-4"></i> Device Name
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-2">
                                <i data-lucide="type" class="w-4 h-4"></i> Type
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-2">
                                <i data-lucide="layers" class="w-4 h-4"></i> Current Zone
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-2">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i> Assign to Zone
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-gray-200">
                    @forelse($devices as $device)
                        <tr class="border-t border-gray-700 hover:bg-[#232323] transition">
                            <td class="px-6 py-4 font-medium">{{ $device->device_name }}</td>
                            <td class="px-6 py-4">{{ $device->device_type }}</td>
                            <td class="px-6 py-4 text-gray-400">
                                {{ $device->zone ? $device->zone->name : 'Unassigned' }}
                            </td>
                            <td class="px-6 py-4">
                                <select name="devices[{{ $device->id }}]"
                                        class="bg-[#2f2f2f] border border-gray-600 text-white px-4 py-2 rounded-lg w-full focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Select Zone --</option>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->id }}" {{ $device->zone_id == $zone->id ? 'selected' : '' }}>
                                            {{ $zone->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-gray-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i data-lucide="alert-circle" class="w-6 h-6 text-gray-500"></i>
                                    <span>No devices found.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="h-6"></div>



        <!-- Buttons -->
        <div class="flex justify-between items-center">
            <div>
                {{ $devices->withQueryString()->links() }}
            </div>
            <div class="flex gap-4">
                 <button type="reset" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded shadow text-sm">
                    Reset
                </button>
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-black font-semibold px-6 py-2 rounded shadow flex items-center gap-2 text-sm">
                    <i data-lucide="save"></i> Save Changes
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection
