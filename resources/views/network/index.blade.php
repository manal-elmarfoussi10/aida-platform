@extends('layouts.app')
@section('title', 'Network Devices')

@section('content')

@if ($errors->any())
    <div class="bg-red-600 text-white px-4 py-2 mb-4 rounded">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

@if (session('status'))
    <div class="bg-green-600 text-white px-4 py-2 mb-4 rounded shadow">
        {{ session('status') }}
    </div>
@endif

<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Network Devices</h2>
        <div class="flex gap-4">
            <form action="{{ route('network.scan') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 hover:bg-green-400 text-black font-semibold px-6 py-2 rounded-lg shadow-lg">
                    Scan Network
                </button>
            </form>
            <button onclick="openQrScanner()" class="bg-blue-500 hover:bg-blue-400 text-black font-semibold px-6 py-2 rounded-lg shadow-lg">
                Scan QR
            </button>
        </div>
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
                    @php
                        $isArray = is_array($device);
                        $online = $isArray ? ($device['online_status'] ?? false) : $device->online_status;
                        $enabled = $isArray ? ($device['enabled'] ?? false) : $device->enabled;
                        $id = $isArray ? null : $device->id;
                    @endphp
                    <tr class="border-b border-gray-700 hover:bg-[#2a2a2a]">
                        <td class="px-6 py-4">{{ $isArray ? $device['device_name'] ?? 'N/A' : $device->device_name }}</td>
                        <td class="px-6 py-4">{{ $isArray ? $device['type'] ?? 'Unknown' : $device->type }}</td>
                        <td class="px-6 py-4">{{ $isArray ? $device['serial_number'] ?? 'Unknown' : $device->serial_number }}</td>
                        <td class="px-6 py-4">{{ $isArray ? $device['mac_address'] ?? 'Unknown' : $device->mac_address }}</td>
                        <td class="px-6 py-4">{{ $isArray ? $device['ip_address'] ?? 'Unknown' : $device->ip_address }}</td>
                        <td class="px-6 py-4">{{ $isArray ? $device['firmware_version'] ?? 'Unknown' : $device->firmware_version }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                {{ $online ? 'bg-green-600' : 'bg-red-600' }}">
                                {{ $online ? 'Online' : 'Offline' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if ($id)
                                <form method="POST" action="{{ route('network.toggle', $id) }}">
                                    @csrf
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="enabled" onchange="this.form.submit()" class="sr-only" {{ $enabled ? 'checked' : '' }}>
                                        <div class="relative w-10 h-5 transition rounded-full {{ $enabled ? 'bg-green-500' : 'bg-gray-600' }}">
                                            <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full transition {{ $enabled ? 'translate-x-5' : '' }}"></div>
                                        </div>
                                        <span class="ml-2 text-xs font-bold">
                                            {{ $enabled ? 'ON' : 'OFF' }}
                                        </span>
                                    </label>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs">Live Scan</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- QR Scanner Modal -->
    <div id="qrModal" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center hidden z-50">
        <div class="bg-[#1e1e1e] p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <button onclick="closeQrScanner()" class="absolute top-2 right-3 text-white text-xl">&times;</button>
            <h3 class="text-white text-lg font-bold mb-4">Scan QR Code</h3>

            <div class="relative w-full h-64 border-2 border-green-500 overflow-hidden rounded-md">
                <div id="qr-reader" style="width: 100%; height: 100%;"></div>
                <div class="absolute w-full h-1 bg-green-400 animate-scan-line"></div>
            </div>

            <div id="qr-result" class="mt-4 text-green-400 font-semibold text-center">Use a valid QR code to register a device.</div>
            <form id="createDeviceForm" action="{{ route('network.createFromQr') }}" method="POST" class="mt-4 hidden">
                @csrf
                <input type="hidden" name="qr_data" id="qrDataInput">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white py-2 rounded font-semibold">
                    Create Device
                </button>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes scanLine {
    0% { top: 0%; }
    100% { top: 100%; }
}
.animate-scan-line {
    animation: scanLine 2s linear infinite alternate;
}
</style>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrCode;

    function openQrScanner() {
        document.getElementById('qrModal').classList.remove('hidden');
        html5QrCode = new Html5Qrcode("qr-reader");

        html5QrCode.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            (decodedText) => {
                document.getElementById('qr-result').innerText = "Scanned: " + decodedText;
                document.getElementById('qrDataInput').value = decodedText;
                document.getElementById('createDeviceForm').classList.remove('hidden');
                html5QrCode.stop();
            },
            (errorMessage) => {
                // silent fail
            }
        ).catch(err => {
            document.getElementById('qr-result').innerText = "Camera error: " + err;
        });
    }

    function closeQrScanner() {
        document.getElementById('qrModal').classList.add('hidden');
        document.getElementById('qr-result').innerText = "Use a valid QR code to register a device.";
        document.getElementById('createDeviceForm').classList.add('hidden');
        if (html5QrCode) {
            html5QrCode.stop().then(() => html5QrCode.clear()).catch(console.error);
        }
    }
</script>
@endsection