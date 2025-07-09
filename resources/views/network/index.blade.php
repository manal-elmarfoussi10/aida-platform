@extends('layouts.app')
@section('title', 'Network Devices')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Network Devices</h2>
        <form action="{{ route('network.scan') }}" method="POST">
            @csrf
            <button class="bg-green-500 hover:bg-green-400 text-black font-semibold px-6 py-2 rounded-lg shadow-lg">
                Scan Network
            </button>
        </form>
    </div>

    @if(session('status'))
        <div class="mb-4 text-green-400">{{ session('status') }}</div>
    @endif

    {{-- Search Input --}}
    <div class="mb-4">
        <input type="text" placeholder="Search" class="w-1/3 px-4 py-2 rounded bg-gray-800 border border-gray-600 text-white focus:outline-none focus:ring focus:border-blue-300">
    </div>

    <div class="overflow-x-auto bg-[#1e1e1e] rounded-lg shadow">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#2a2a2a] text-white">
                <tr>
                    <th class="px-6 py-3">Device Name</th>
                    <th class="px-6 py-3">Type</th>
                    <th class="px-6 py-3">Serial Number</th>
                    <th class="px-6 py-3">MAC Address</th>
                    <th class="px-6 py-3">IP Address</th>
                    <th class="px-6 py-3">Firmware Version</th>
                    <th class="px-6 py-3">Online Status</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($devices as $device)
                    <tr class="border-b border-gray-700 hover:bg-[#2a2a2a]">
                        <td class="px-6 py-4">{{ $device->device_name }}</td>
                        <td class="px-6 py-4">{{ $device->type }}</td>
                        <td class="px-6 py-4">{{ $device->serial_number }}</td>
                        <td class="px-6 py-4">{{ $device->mac_address }}</td>
                        <td class="px-6 py-4">{{ $device->ip_address }}</td>
                        <td class="px-6 py-4">{{ $device->firmware_version }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                {{ $device->online_status ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
                                {{ $device->online_status ? 'Online' : 'Offline' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form method="POST" action="{{ route('network.toggle', $device->id) }}">
                                @csrf
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="enabled" onchange="this.form.submit()" class="sr-only" {{ $device->enabled ? 'checked' : '' }}>
                                    <div class="relative w-10 h-5 transition rounded-full
                                        {{ $device->enabled ? 'bg-green-500' : 'bg-gray-600' }}">
                                        <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full transition
                                            {{ $device->enabled ? 'translate-x-5' : '' }}"></div>
                                    </div>
                                    <span class="ml-2 text-xs font-bold">
                                        {{ $device->enabled ? 'ON' : 'OFF' }}
                                    </span>
                                </label>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
