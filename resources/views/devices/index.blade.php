@extends('layouts.app')
@section('title', 'Device Control')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold tracking-wide">Device Control</h2>
        <a href="{{ route('devices.create') }}"
           class="bg-green-500 text-black px-5 py-2 rounded hover:bg-green-400 shadow-lg transition-all">
            Add New Device
        </a>
    </div>

    {{-- Search bar --}}
    <div class="relative w-1/3 mb-6">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i data-lucide="search" class="w-4 h-4"></i>
        </span>
        <input type="text" placeholder="Search devices..."
               class="h-10 text-sm pl-10 pr-4 py-2 w-full bg-gray-800 text-white border border-gray-600 rounded placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-400">
    </div>

    {{-- Device table --}}
    <div class="bg-[#1e1e1e] rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-black">
                <tr>
                    <th class="px-4 py-3 font-semibold">Zone</th>
                    <th class="px-4 py-3 font-semibold">Device Type</th>
                    <th class="px-4 py-3 font-semibold">Device Name</th>
                    <th class="px-4 py-3 font-semibold">Current Status</th>
                    <th class="px-4 py-3 font-semibold">Last Updated</th>
                    <th class="px-4 py-3 font-semibold">Manual Control</th>
                    <th class="px-4 py-3 font-semibold text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($devices as $device)
                <tr class="border-b border-gray-700 hover:bg-[#2a2a2a]">
                    <td class="px-4 py-3">{{ $device->zone }}</td>
                    <td class="px-4 py-3">{{ $device->device_type }}</td>
                    <td class="px-4 py-3">{{ $device->device_name }}</td>

                    {{-- Toggle for current status --}}
                    <td class="px-4 py-3">
                        <button
                            data-id="{{ $device->id }}"
                            data-status="{{ $device->current_status ? 1 : 0 }}"
                            class="toggle-current flex items-center justify-between w-20 h-8 px-2 rounded-full font-bold text-sm transition-all duration-300
                                {{ $device->current_status ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                            <span class="z-10">{{ $device->current_status ? 'ON' : 'OFF' }}</span>
                            <div class="circle w-5 h-5 rounded-full bg-white shadow transition-transform duration-300"
                                 style="{{ $device->current_status ? 'transform: translateX(0)' : 'transform: translateX(24px)' }}">
                            </div>
                        </button>
                    </td>

                    <td class="px-4 py-3">{{ $device->updated_at->format('Y-m-d H:i') }}</td>

                    {{-- Toggle for manual control --}}
                    <td class="px-4 py-3">
                        <button
                            data-id="{{ $device->id }}"
                            data-status="{{ $device->manual_control ? 1 : 0 }}"
                            class="toggle-manual flex items-center justify-between w-20 h-8 px-2 rounded-full font-bold text-sm transition-all duration-300
                                {{ $device->manual_control ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                            <span class="z-10">{{ $device->manual_control ? 'ON' : 'OFF' }}</span>
                            <div class="circle w-5 h-5 rounded-full bg-white shadow transition-transform duration-300"
                                 style="{{ $device->manual_control ? 'transform: translateX(0)' : 'transform: translateX(24px)' }}">
                            </div>
                        </button>
                    </td>

                    <td class="px-4 py-3 text-center flex justify-center gap-3">
                        <a href="{{ route('devices.edit', $device) }}" class="text-green-400 hover:text-green-600">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('devices.destroy', $device) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Toggle scripts --}}
<script>
    document.querySelectorAll('.toggle-current').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const newStatus = this.dataset.status === "1" ? 0 : 1;
            const btn = this;

            fetch(`/devices/${id}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    btn.dataset.status = data.newStatus;
                    btn.classList.toggle('bg-green-500', data.newStatus);
                    btn.classList.toggle('bg-red-500', !data.newStatus);
                    btn.querySelector('span').textContent = data.newStatus ? 'ON' : 'OFF';
                    btn.querySelector('.circle').style.transform = data.newStatus ? 'translateX(0)' : 'translateX(24px)';
                }
            });
        });
    });

    document.querySelectorAll('.toggle-manual').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const newStatus = this.dataset.status === "1" ? 0 : 1;
            const btn = this;

            fetch(`/devices/${id}/toggle-manual`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    btn.dataset.status = data.newStatus;
                    btn.classList.toggle('bg-green-500', data.newStatus);
                    btn.classList.toggle('bg-red-500', !data.newStatus);
                    btn.querySelector('span').textContent = data.newStatus ? 'ON' : 'OFF';
                    btn.querySelector('.circle').style.transform = data.newStatus ? 'translateX(0)' : 'translateX(24px)';
                }
            });
        });
    });
</script>
@endsection