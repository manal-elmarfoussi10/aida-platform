@extends('layouts.app')

@section('title', 'Facility Overview')

@section('content')
<div class="p-6 space-y-6 text-white">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Centre de Supervision</h1>
            <p class="text-gray-400">Suivi temps réel de l’état des zones et des équipements</p>
        </div>
        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center gap-2">
            <i data-lucide="refresh-ccw" class="w-4 h-4"></i> Rafraîchir
        </button>
    </div>

    <!-- Zones + System Status -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <x-kpi-box icon="layers" label="Zones Opérationnelles" value="12" />
        <x-kpi-box icon="activity" label="Équipements Actifs" value="47" />
        <x-kpi-box icon="zap-off" label="Pannes Signalées" value="3" type="error" />
        <x-kpi-box icon="battery-charging" label="Économie Énergétique" value="18%" type="success" />
    </div>

    <!-- Graphique principal -->
    <div class="bg-[#1e1e1e] p-6 rounded-lg shadow-lg">
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-semibold">Consommation Électrique par Zone</h2>
            <span class="text-sm text-gray-500">Dernière mise à jour : {{ now()->format('H:i') }}</span>
        </div>
        <canvas id="zoneEnergyChart" height="140"></canvas>
    </div>

    <!-- Alertes et Maintenance -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Alertes -->
        <div class="bg-[#1e1e1e] p-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-3">Alertes Critiques</h3>
            <ul class="space-y-3 text-sm text-red-400">
                <li><i data-lucide="alert-triangle" class="inline w-4 h-4 mr-1"></i> Zone B : température anormale</li>
                <li><i data-lucide="cpu" class="inline w-4 h-4 mr-1"></i> HVAC Zone D : surconsommation détectée</li>
                <li><i data-lucide="wifi-off" class="inline w-4 h-4 mr-1"></i> Capteur CO₂ déconnecté - Zone A</li>
            </ul>
        </div>

        <!-- Prochaines Interventions -->
        <div class="bg-[#1e1e1e] p-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-3">Maintenance Planifiée</h3>
            <ul class="space-y-3 text-sm text-gray-300">
                <li>🔧 <strong>3 Juil</strong> – Mise à jour firmware HVAC - Zone C</li>
                <li>🧰 <strong>6 Juil</strong> – Inspection manuelle capteurs lumière</li>
                <li>📶 <strong>9 Juil</strong> – Calibration réseau ZigBee</li>
            </ul>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    lucide.createIcons();

    const ctx = document.getElementById('zoneEnergyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Zone A', 'Zone B', 'Zone C', 'Zone D'],
            datasets: [{
                data: [230, 180, 160, 200],
                backgroundColor: ['#10b981', '#3b3b3b', '#3b3b3b', '#3b3b3b'],
                borderRadius: 8
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { ticks: { color: '#999' }, grid: { color: '#2e2e2e' } },
                x: { ticks: { color: '#ccc' }, grid: { display: false } }
            }
        }
    });
</script>
@endsection
