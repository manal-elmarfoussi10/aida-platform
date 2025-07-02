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

        <div>
            <label class="block mb-2 text-sm font-medium">Zone Name</label>
            <input type="text" name="name" value="{{ old('name', $zone->name) }}" required
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Zone Type</label>
            <select name="zone_type" required
                    class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
                <option value="">Select type</option>
                <option value="HVAC" {{ $zone->zone_type == 'HVAC' ? 'selected' : '' }}>HVAC</option>
                <option value="Lighting" {{ $zone->zone_type == 'Lighting' ? 'selected' : '' }}>Lighting</option>
                <option value="Shade" {{ $zone->zone_type == 'Shade' ? 'selected' : '' }}>Shade</option>
            </select>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Occupancy</label>
            <input type="number" name="occupancy" value="{{ old('occupancy', $zone->occupancy) }}"
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Temperature / Humidity</label>
            <input type="text" name="temperature_humidity" value="{{ old('temperature_humidity', $zone->temperature_humidity) }}"
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Energy Usage (kWh)</label>
            <input type="text" name="energy_usage" value="{{ old('energy_usage', $zone->energy_usage) }}"
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
        </div>

        <div class="flex items-center mt-4">
            <input type="hidden" name="status" value="0">
            <input type="checkbox" name="status" value="1" id="status"
                {{ $zone->status ? 'checked' : '' }}
                class="mr-2 w-5 h-5 text-green-500 bg-gray-700 border-gray-600 rounded focus:ring-green-600">
            <label for="status" class="text-white">Zone Active (ON)</label>
        </div>

        <div class="text-right">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-black font-semibold px-6 py-2 rounded transition-all shadow">
                Update Zone
            </button>
        </div>
    </form>
</div>
@endsection