@extends('layouts.app')

@section('content')
<div class="px-6 py-8 text-white">
    <h1 class="text-2xl font-bold mb-6">Controls</h1>

    <!-- Device Select -->
    <form id="controlsForm" method="POST" action="{{ route('controls.update', ['id' => $device->id]) }}">
        @csrf
        <input type="hidden" id="deviceId" value="{{ $device->id }}">

        <div class="flex gap-4 mb-6">
            <div>
                <label class="block text-m mb-1">Device</label>
                <select id="deviceSelect" name="device_id"
                    class="w-64 bg-[rgb(44,44,44)] text-white px-4 py-2 rounded-md border border-gray-500 shadow-sm focus:outline-none">
                    @foreach ($devices as $d)
                        <option value="{{ $d->id }}" {{ $d->id === $device->id ? 'selected' : '' }}>
                            {{ $d->device_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column: HVAC + Shades -->
            <div class="flex flex-col gap-6">
                <!-- HVAC Card -->
                <div class="bg-[rgb(44,44,44)] p-6 rounded-2xl shadow">
                    <div class="flex justify-center items-center bg-[#2C2C2C] p-6 rounded-2xl w-full max-w-xs mx-auto flex-col">
                        <div class="flex gap-2 mb-4">
                            <i class="fas fa-thermometer-half text-sky-400 text-xl"></i>
                            <h2 class="font-bold text-xl">HVAC</h2>
                        </div>
                        <h2 class="text-white text-lg font-semibold mb-4">Thermostat</h2>
                        <div class="bg-gradient-to-b from-blue-300 to-blue-700 rounded-full w-40 h-40 flex items-center justify-center mb-4">
                            <span class="text-white text-3xl font-bold" id="temperatureDisplay">{{ $device->temperature }}°C</span>
                        </div>
                        <input 
                            type="range" 
                            name="temperature"
                            min="10" 
                            max="30" 
                            value="{{ $device->temperature }}"
                            class="w-full h-2 rounded-lg appearance-none bg-gray-700 accent-blue-400"
                            oninput="document.getElementById('temperatureDisplay').innerText = this.value + '°C';"
                        >
                    </div>
                </div>

                <!-- Shades Card -->
                <div class="bg-[rgb(44,44,44)] p-6 rounded-2xl shadow">
                 <!-- Shades Card -->
<div class="bg-[rgb(44,44,44)] p-6 rounded-2xl shadow">
    <h2 class="text-white text-lg font-semibold flex items-center gap-2 mb-4">
        <i class="fas fa-th-large text-sky-300"></i> Shades
    </h2>
    <p class="mb-1">Shade Position</p>
    <input 
        type="range" 
        name="shades"
        id="shadesSlider"
        min="0" 
        max="100" 
        value="{{ $device->shades }}" 
        class="w-full accent-sky-300"
        oninput="document.getElementById('shadesValue').innerText = this.value + '%'"
    >
    <p id="shadesValue">{{ $device->shades }}%</p>
</div>
                </div>
            </div>

            <!-- Right Column: Lights -->
            <div class="bg-[#2c2c2c] rounded-xl p-6 text-white row-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <i class="fas fa-lightbulb text-yellow-400 text-xl"></i>
                    <h2 class="font-bold text-xl">Lights</h2>
                </div>

                <!-- Dimmer -->
                <div class="flex flex-col items-center mb-6">
                    <p class="text-lg mb-2">Dimmer</p>
                    <input 
                        type="range" 
                        name="dimmer" 
                        min="0" 
                        max="100" 
                        value="{{ $device->dimmer }}"
                        class="w-full h-2 rounded-full appearance-none"
                        style="background: linear-gradient(to right, #FFD700, #4B3B0A);"
                        oninput="document.getElementById('dimmerLabel').innerText = this.value + '%';"
                    >
                    <p class="mt-2 text-lg" id="dimmerLabel">{{ $device->dimmer }}%</p>
                </div>

                <!-- Color Temperature -->
                <div class="flex flex-col items-center mb-6">
                    <i class="fas fa-lightbulb text-orange-400 text-2xl mb-2"></i>
                    <p class="text-lg mb-2">Color Temperature</p>
                    <div class="relative w-full max-w-sm h-10 mb-2">
                        <div class="absolute top-0 left-0 right-0 bottom-0 rounded-full overflow-hidden">
                            <div class="w-full h-full bg-gradient-to-r from-yellow-400 via-white to-sky-400 rounded-full"></div>
                            <div class="absolute top-1/2 left-0 right-0 h-[2px] bg-green-500 transform -translate-y-1/2"></div>
                        </div>
                        <input
                            type="range"
                            name="color_temperature"
                            min="1000"
                            max="10000"
                            value="{{ $device->color_temperature }}"
                            class="w-full h-full appearance-none bg-transparent z-10 relative custom-thumb"
                            oninput="document.getElementById('colorTempLabel').innerText = this.value + 'K';"
                        />
                    </div>
                    <p class="text-lg" id="colorTempLabel">{{ $device->color_temperature }}K</p>
                </div>

                <!-- RGB Color -->
                <div class="flex flex-col items-center">
                    <i class="fas fa-palette text-red-500 text-2xl mb-2"></i>
                    <p class="text-lg mb-2">RGB Color</p>
                    <input 
                        type="color" 
                        name="rgb_color" 
                        value="{{ $device->rgb_color ?? '#ff0000' }}" 
                        class="w-24 h-12 rounded"
                    >
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Update</button>
        </div>
    </form>
</div>

<!-- Styles for custom thumbs -->
<style>
    .custom-thumb::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 24px;
        height: 24px;
        border-radius: 9999px;
        background: white;
        border: 2px solid #ccc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        z-index: 20;
    }
    .custom-thumb::-moz-range-thumb {
        width: 24px;
        height: 24px;
        border-radius: 9999px;
        background: white;
        border: 2px solid #ccc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        z-index: 20;
    }
</style>

<!-- Live JS logic -->
<script>
    document.getElementById('deviceSelect').addEventListener('change', function () {
        window.location.href = '/controls/' + this.value;
    });

    document.getElementById('controlsForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const id = document.getElementById('deviceId').value;

        fetch(`/controls/update/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name=_token]').value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert('Device updated!');
        })
        .catch(err => {
            console.error(err);
            alert('Update failed.');
        });
    });
</script>
@endsection