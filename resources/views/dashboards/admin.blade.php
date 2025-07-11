@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex-1 overflow-y-auto p-6 text-white">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Hello {{ Auth::user()->name }}</h2>
        <p class="text-green-400">Dashboard / Attendance Insights</p>
    </div>

    <!-- Site Selection -->
    <form method="GET" action="{{ route('dashboard.admin') }}" class="mb-4 max-w-xs">
        <label for="site" class="block mb-1 text-sm">Select Site</label>
        <select name="site_id" id="site" onchange="this.form.submit()"
                class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500">
            @foreach($sites as $s)
                <option value="{{ $s->id }}" {{ $selectedSite && $selectedSite->id == $s->id ? 'selected' : '' }}>
                    {{ $s->name }}
                </option>
            @endforeach
        </select>
    </form>

    <!-- Banner from image_url -->
    @if($selectedSite && $selectedSite->image_url)
        <div class="relative overflow-hidden rounded-lg mb-6">
            <img src="{{ $selectedSite->image_url }}" alt="{{ $selectedSite->name }}" class="w-full h-64 object-cover">
            <div class="absolute bottom-4 left-4 text-white bg-black bg-opacity-40 px-4 py-2 rounded">
                <h1 class="text-4xl font-bold">{{ $selectedSite->name }}</h1>
                <p class="text-xl text-gray-300">{{ $selectedSite->city }}</p>
            </div>
        </div>
    @endif

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-[#1f1f1f] p-4 rounded shadow flex flex-col items-start">
            <i data-lucide="zap" class="mb-2 text-green-400 w-6 h-6"></i>
            <h2 class="text-2xl font-bold">{{ number_format($energyUsage, 2) }} kWh</h2>
            <p class="text-sm text-gray-400">Energy Usage</p>
        </div>
        <div class="bg-[#1f1f1f] p-4 rounded shadow flex flex-col items-start">
            <i data-lucide="percent" class="mb-2 text-green-400 w-6 h-6"></i>
            <h2 class="text-2xl font-bold">{{ number_format($savingsPercentage) }}%</h2>
            <p class="text-sm text-gray-400">Savings Summary</p>
            <p class="text-sm text-green-400">This Month: {{ number_format($savingsPercentage) }}% Energy saving</p>
        </div>
        <div class="bg-[#1f1f1f] p-4 rounded shadow flex flex-col items-start">
            <i data-lucide="users" class="mb-2 text-green-400 w-6 h-6"></i>
            <h2 class="text-2xl font-bold">{{ number_format($occupancyRate, 2) }}%</h2>
            <p class="text-sm text-gray-400">Occupancy Rate</p>
        </div>
        <div class="bg-[#1f1f1f] p-4 rounded shadow flex flex-col items-start">
            <i data-lucide="leaf" class="mb-2 text-green-400 w-6 h-6"></i>
            <h2 class="text-2xl font-bold">{{ number_format($environmentalImpact) }} kg</h2>
            <p class="text-sm text-gray-400">Environmental Impact</p>
            <p class="text-sm text-green-400">{{ number_format($environmentalImpact) }} Kg CO2 Reduced</p>
        </div>
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