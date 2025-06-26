@extends('layouts.app')

@section('title', 'Facility Manager')

@section('content')
<div class="p-6 text-white flex flex-col gap-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold">Bienvenue, {{ Auth::user()->name }}</h1>
            <p class="text-gray-400">Vue d’ensemble de vos zones et consommations</p>
        </div>
        <div class="w-full md:w-72 relative">
            <input type="text" placeholder="Recherche rapide..."
                   class="w-full pl-10 pr-4 py-2 rounded-lg bg-[#1a1a1a] text-sm text-white placeholder-gray-400 border border-gray-700 focus:ring-2 focus:ring-green-500">
            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
        </div>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $kpis = [
                ['label' => 'Zones Actives', 'value' => '08', 'icon' => 'layout-grid'],
                ['label' => 'Événements Critiques', 'value' => '04', 'icon' => 'alert-circle', 'color' => 'text-red-500'],
                ['label' => 'Consommation Moyenne', 'value' => '725 KWH', 'icon' => 'zap'],
                ['label' => 'Maintenance Planifiée', 'value' => '2 interventions', 'icon' => 'calendar']
            ];
        @endphp
        @foreach($kpis as $kpi)
            <div class="bg-[#1f1f1f] p-5 rounded-lg flex justify-between items-center shadow-sm">
                <div>
                    <p class="text-sm text-gray-400">{{ $kpi['label'] }}</p>
                    <h3 class="text-2xl font-semibold mt-1">{{ $kpi['value'] }}</h3>
                </div>
                <i data-lucide="{{ $kpi['icon'] }}" class="w-6 h-6 {{ $kpi['color'] ?? 'text-green-400' }}"></i>
            </div>
        @endforeach
    </div>

    <!-- Graphique + Alertes -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart -->
        <div class="col-span-2 bg-[#1f1f1f] p-6 rounded-lg shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Consommation par Zone</h2>
                <span class="text-sm text-gray-400">Mis à jour : {{ now()->format('d M Y') }}</span>
            </div>
            <canvas id="zoneChart" height="200"></canvas>
        </div>

        <!-- Alertes -->
        <div class="bg-[#1f1f1f] p-6 rounded-lg shadow-sm">
            <h2 class="text-lg font-semibold mb-4">Alertes Récentes</h2>
            <ul class="space-y-4 text-sm text-gray-300">
                <li class="flex gap-3">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500"></i>
                    Zone B – Perte de signal capteur CO₂
                </li>
                <li class="flex gap-3">
                    <i data-lucide="thermometer" class="w-5 h-5 text-yellow-400"></i>
                    Zone C – Température élevée détectée
                </li>
                <li class="flex gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500"></i>
                    Zone A – Maintenance complétée
                </li>
            </ul>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    lucide.createIcons();

    const ctx = document.getElementById('zoneChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Zone A', 'Zone B', 'Zone C', 'Zone D'],
            datasets: [{
                label: 'KWH',
                data: [250, 200, 190, 220],
                backgroundColor: ['#10b981', '#3b3b3b', '#3b3b3b', '#3b3b3b'],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { ticks: { color: '#999' }, grid: { color: '#333' } },
                x: { ticks: { color: '#aaa' }, grid: { display: false } }
            }
        }
    });
</script>
@endsection
