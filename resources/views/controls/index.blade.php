@extends('layouts.app')
@section('title', 'Controls')

@section('content')
<div class="max-w-screen-xl mx-auto px-6 py-10 text-white space-y-10">

    <!-- Header & Filters -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h2 class="text-3xl font-bold">Controls</h2>

        <form method="GET" action="{{ route('controls.index') }}" class="flex flex-wrap gap-4">
            <!-- Zone Filter -->
            <select name="zone_id" onchange="this.form.submit()"
                class="bg-[#222] border border-gray-700 text-sm text-white px-4 py-2 rounded shadow">
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}" {{ $zoneId == $zone->id ? 'selected' : '' }}>
                        {{ $zone->name }}
                    </option>
                @endforeach
            </select>

            <!-- Type Filter -->
            @php
                $deviceTypes = ['thermostat' => 'Thermostat', 'light' => 'Light', 'shade' => 'Shade'];
            @endphp
            <select name="device_type" onchange="this.form.submit()"
                class="bg-[#222] border border-gray-700 text-sm text-white px-4 py-2 rounded shadow">
                <option value="">All Devices</option>
                @foreach($deviceTypes as $type => $label)
                    <option value="{{ $type }}" {{ request('device_type') == $type ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Device Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($devices as $device)
            @php
                $settings = is_array($device->settings) ? $device->settings : json_decode($device->settings, true);
            @endphp

            <!-- Thermostat -->
            @if($device->type === 'thermostat')
                <div class="bg-[#1c1c1c] p-6 rounded-lg shadow space-y-4">
                    <div class="flex items-center gap-2 text-lg text-blue-400 font-semibold">
                        <i data-lucide="thermometer" class="w-5 h-5"></i>
                        HVAC
                    </div>

                    <form method="POST" action="{{ route('controls.update', $device) }}">
                        @csrf
                        <div class="flex items-center justify-between">
                            <div class="text-center">
                                <div class="text-4xl bg-blue-500 text-black w-24 h-24 rounded-full flex items-center justify-center shadow font-bold">
                                    {{ $settings['temperature'] ?? 22 }}°C
                                </div>
                                <p class="mt-2 text-sm text-gray-400">Thermostat</p>
                            </div>
                            <input type="range" name="temperature" min="10" max="35" step="1"
                                value="{{ $settings['temperature'] ?? 22 }}" class="w-32 accent-blue-400">
                        </div>
                        <div class="text-right mt-4">
                            <button class="bg-green-500 text-black text-sm px-4 py-2 rounded shadow">Save</button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Light -->
            @if($device->type === 'light')
                <div class="bg-[#1c1c1c] p-6 rounded-lg shadow space-y-4">
                    <div class="flex items-center gap-2 text-lg text-yellow-400 font-semibold">
                        <i data-lucide="lightbulb" class="w-5 h-5"></i>
                        Lights
                    </div>

                    <form method="POST" action="{{ route('controls.update', $device) }}">
                        @csrf
                        <label class="block mt-2 text-sm">Dimmer</label>
                        <input type="range" name="dimmer" min="0" max="100"
                            value="{{ $settings['dimmer'] ?? 50 }}" class="w-full accent-yellow-300">
                        <p class="text-sm text-yellow-200">{{ $settings['dimmer'] ?? 50 }}%</p>

                        <label class="block mt-4 text-sm">Color Temperature</label>
                        <input type="range" name="color_temperature" min="2700" max="6500" step="100"
                            value="{{ $settings['color_temperature'] ?? 3500 }}"
                            class="w-full bg-gradient-to-r from-yellow-100 via-white to-blue-300 accent-white">
                        <p class="text-sm text-yellow-100">{{ $settings['color_temperature'] ?? 3500 }}K</p>

                        <label class="block mt-4 text-sm">RGB Color</label>
                        <input type="color" name="rgb" value="{{ $settings['rgb'] ?? '#ffaa00' }}"
                            class="w-12 h-8 rounded shadow border-none">

                        <div class="text-right mt-4">
                            <button class="bg-green-500 text-black text-sm px-4 py-2 rounded shadow">Save</button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Shade -->
            @if($device->type === 'shade')
                <div class="bg-[#1c1c1c] p-6 rounded-lg shadow space-y-4">
                    <div class="flex items-center gap-2 text-lg text-cyan-300 font-semibold">
                        <i data-lucide="layout-grid" class="w-5 h-5"></i>
                        Shades
                    </div>

                    <form method="POST" action="{{ route('controls.update', $device) }}">
                        @csrf
                        <label class="block mt-2 text-sm">Shade Position</label>
                        <input type="range" name="position" min="0" max="100"
                            value="{{ $settings['position'] ?? 50 }}" class="w-full accent-cyan-300">
                        <p class="text-sm text-cyan-200">{{ $settings['position'] ?? 50 }}%</p>

                        <div class="text-right mt-4">
                            <button class="bg-green-500 text-black text-sm px-4 py-2 rounded shadow">Save</button>
                        </div>
                    </form>
                </div>
            @endif

        @empty
            <p class="text-gray-400 col-span-full text-center">Aucun device trouvé pour cette zone/type.</p>
        @endforelse
    </div>
</div>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection

