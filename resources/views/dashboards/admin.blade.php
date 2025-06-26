@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex-1 overflow-y-auto p-6 text-white">
    <!-- Header + Search -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold mb-1">Hello {{ Auth::user()->name }},</h2>
            <p class="text-green-400">Attendance Insights</p>
        </div>
        <div class="relative w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i data-lucide="search" class="w-4 h-4 text-gray-500"></i>
            </span>
            <input
                type="text"
                placeholder="Search"
                class="pl-10 pr-4 py-2 w-full rounded bg-white text-black focus:outline-none focus:ring-2 focus:ring-green-400"
            >
        </div>
    </div>

    <!-- Time + Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-[#1f1f1f] p-4 rounded">
            <div class="text-2xl flex items-center gap-2">
                <i data-lucide="sun"></i> <span id="time">{{ now()->format('h:i:s A') }}</span>
            </div>
            <p class="text-sm text-gray-400">Realtime Insight</p>
            <p class="mt-2 text-sm">Today:</p>
            <p class="text-white font-semibold">{{ now()->format('jS F Y') }}</p>
            <button class="mt-3 bg-green-500 px-3 py-1 rounded text-sm">Advanced Configuration</button>
        </div>

        @php
        $metrics = [
            ['title' => 'Energy Usage', 'value' => '120 KWH', 'icon' => 'zap'],
            ['title' => 'Savings Summary', 'value' => '15%', 'subtitle' => 'This Month 15% Energy saving', 'icon' => 'badge-percent'],
            ['title' => 'Cost Saving', 'value' => '500$', 'subtitle' => '+3% Increase than yesterday', 'icon' => 'wallet', 'textClass' => 'text-red-400'],
            ['title' => 'Zones List', 'value' => '10', 'icon' => 'search'],
            ['title' => 'Environmental Impact', 'value' => '100 kg', 'subtitle' => '100 Kg CO2 Reduced', 'icon' => 'leaf'],
            ['title' => 'Configuration', 'value' => '15', 'icon' => 'settings']
        ];
        @endphp

        @foreach($metrics as $metric)
        <div class="bg-[#1a1a1a] p-4 rounded shadow flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-400">{{ $metric['title'] }}</p>
                <h2 class="text-xl font-bold">{{ $metric['value'] }}</h2>
                @if(isset($metric['subtitle']))
                    <p class="text-sm {{ $metric['textClass'] ?? 'text-green-400' }}">{{ $metric['subtitle'] }}</p>
                @endif
            </div>
            <div class="bg-black rounded-full p-2">
                <i data-lucide="{{ $metric['icon'] }}" class="w-5 h-5 text-green-400"></i>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
        <div class="bg-[#1f1f1f] p-4 rounded">
            <div class="flex justify-between items-center mb-2">
                <p class="text-lg">Energy Saving Chart</p>
                <div class="flex space-x-2 text-sm">
                    <span class="text-green-400">● Daily</span>
                    <span class="text-gray-400">○ Weekly</span>
                    <span class="text-gray-400">○ Monthly</span>
                </div>
            </div>
            <canvas id="energyChart" height="150"></canvas>
        </div>
        <div class="bg-[#1f1f1f] p-4 rounded">
            <p class="text-lg mb-4">Cost Saving</p>
            <canvas id="costChart" height="150"></canvas>
        </div>
    </div>

    <!-- Alerts & Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 mt-8 gap-4">
        <div class="bg-[#1f1f1f] p-4 rounded">
            <p class="font-semibold mb-2">Live Alerts</p>
            <ul class="text-sm list-disc ml-5 text-gray-300 space-y-1">
                <li>Zone B HVAC system inefficiency detected – 15% Energy Loss</li>
                <li>Lighting system in Zone A offline</li>
            </ul>
        </div>
        <div class="bg-[#1f1f1f] p-4 rounded">
            <p class="font-semibold mb-2">Quick actions</p>
            <div class="flex flex-col gap-2">
                <button class="bg-white text-green-500 px-4 py-2 rounded">Scan Network</button>
                <button class="bg-green-500 text-white px-4 py-2 rounded">Control Devices</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();

    const energyCtx = document.getElementById('energyChart').getContext('2d');
    new Chart(energyCtx, {
        type: 'line',
        data: {
            labels: ['01 Aug', '02 Aug', '03 Aug', '04 Aug', '05 Aug', '06 Aug', '07 Aug', '08 Aug', '09 Aug', '10 Aug', '11 Aug', '12 Aug', '13 Aug', '14 Aug', '15 Aug', '16 Aug'],
            datasets: [{
                label: 'Energy Saved',
                data: [60, 63, 65, 70, 74, 91, 55, 60, 65, 70, 75, 80, 76, 72, 60, 78],
                borderColor: 'lime',
                backgroundColor: 'rgba(0,255,0,0.1)',
                tension: 0.4
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });

    const costCtx = document.getElementById('costChart').getContext('2d');
    new Chart(costCtx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            datasets: [{
                label: 'Cost Saving ($)',
                data: [50000, 65000, 86000, 60000, 45000],
                backgroundColor: ['#3b3b3b', '#3b3b3b', '#22c55e', '#3b3b3b', '#3b3b3b']
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });
</script>
@endsection

