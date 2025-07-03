@extends('layouts.app')
@section('title', 'Devices List')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold tracking-wide">Devices List</h2>
        <div class="flex gap-4">
            <a href="{{ route('devices.create') }}"
               class="bg-green-500 text-black px-5 py-2 rounded hover:bg-green-400 shadow-lg transition-all">
                Add New Device
            </a>
            <form action="{{ route('devices.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                @csrf
                <input type="file" name="csv_file" required
                       class="text-sm text-white file:bg-green-500 file:text-black file:border-0 file:px-3 file:py-1.5 file:rounded file:cursor-pointer bg-gray-800 border border-gray-600 rounded">
                <button type="submit"
                        class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-400 shadow-lg transition-all">
                    Upload CSV
                </button>
            </form>
        </div>
    </div>

    {{-- Success Flash Message --}}
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-600 text-black rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search Bar --}}
    <div class="relative w-1/3 mb-6">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i data-lucide="search" class="w-4 h-4"></i>
        </span>
        <input type="text" placeholder="Search devices..."
               class="h-10 text-sm pl-10 pr-4 py-2 w-full bg-gray-800 text-white border border-gray-600 rounded placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-400">
    </div>

    {{-- Table --}}
    <div class="bg-[#1e1e1e] rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#2a2a2a] text-white">
                <tr>
                    <th class="px-4 py-3 font-semibold">Device Name</th>
                    <th class="px-4 py-3 font-semibold">Device Type</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Zone</th>
                    <th class="px-4 py-3 font-semibold">Last Active</th>
                    <th class="px-4 py-3 font-semibold text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($devices as $device)
                <tr class="border-b border-white hover:bg-[#2a2a2a] transition-all">
                    <td class="px-4 py-3">{{ $device->device_name }}</td>
                    <td class="px-4 py-3">{{ $device->device_type }}</td>
                    <td class="px-4 py-3">
                        <livewire:device-toggle :device="$device" :key="$device->id" />
                    </td>
                    <td class="px-4 py-3">{{ $device->zone->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $device->updated_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-3 text-center flex justify-center gap-3">
                        <a href="{{ route('devices.edit', $device) }}" class="text-green-400 hover:text-green-600">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form method="POST" action="{{ route('devices.destroy', $device) }}">
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
                    <td colspan="6" class="text-center py-6 text-gray-500">No devices available.</td>
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