@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="p-6 text-white flex flex-col gap-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Bonjour {{ Auth::user()->name }},</h1>
            <p class="text-green-400">Votre environnement personnel</p>
        </div>
        <div class="relative w-60">
            <input type="text" placeholder="Chercher une zone..."
                   class="w-full pl-10 pr-4 py-2 rounded bg-[#1a1a1a] text-white border border-gray-700 placeholder-gray-400">
            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
        </div>
    </div>

    <!-- Comfort Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-[#1f1f1f] p-5 rounded-lg flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Température actuelle</p>
                <h3 class="text-2xl font-semibold mt-1">22°C</h3>
                <p class="text-sm text-green-400">Confort optimal</p>
            </div>
            <i data-lucide="thermometer" class="w-6 h-6 text-green-400"></i>
        </div>

        <div class="bg-[#1f1f1f] p-5 rounded-lg flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Éclairage</p>
                <h3 class="text-2xl font-semibold mt-1">Modéré</h3>
                <p class="text-sm text-gray-300">650 lux</p>
            </div>
            <i data-lucide="sun" class="w-6 h-6 text-yellow-400"></i>
        </div>

        <div class="bg-[#1f1f1f] p-5 rounded-lg flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Humidité</p>
                <h3 class="text-2xl font-semibold mt-1">45%</h3>
                <p class="text-sm text-green-400">Zone de confort</p>
            </div>
            <i data-lucide="droplet" class="w-6 h-6 text-blue-400"></i>
        </div>
    </div>

    <!-- Emoji Feedback -->
    <div class="bg-[#1f1f1f] p-6 rounded-lg text-sm flex flex-col gap-3">
        <p class="font-semibold text-lg">Comment vous sentez-vous dans cette zone ?</p>
        <div class="flex gap-4 text-2xl">
            <button class="hover:scale-110 transition">😓</button>
            <button class="hover:scale-110 transition">😐</button>
            <button class="hover:scale-110 transition">😊</button>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-[#1f1f1f] p-6 rounded-lg">
        <p class="font-semibold text-lg mb-4">Actions rapides</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <button class="bg-green-500 text-white px-4 py-2 rounded flex items-center justify-center gap-2">
                <i data-lucide="sun" class="w-4 h-4"></i> Activer Lumière
            </button>
            <button class="bg-yellow-500 text-black px-4 py-2 rounded flex items-center justify-center gap-2">
                <i data-lucide="thermometer" class="w-4 h-4"></i> Chauffer
            </button>
            <button class="bg-blue-500 text-white px-4 py-2 rounded flex items-center justify-center gap-2">
                <i data-lucide="fan" class="w-4 h-4"></i> Rafraîchir
            </button>
            <button class="bg-gray-500 text-white px-4 py-2 rounded flex items-center justify-center gap-2">
                <i data-lucide="power" class="w-4 h-4"></i> Tout Éteindre
            </button>
        </div>
    </div>

    <!-- Personal Settings -->
    <div class="bg-[#1f1f1f] p-6 rounded-lg">
        <p class="font-semibold text-lg mb-3">Vos Préférences</p>
        <ul class="text-sm text-gray-300 space-y-2">
            <li>🎯 Température préférée : <span class="text-white">21–23°C</span></li>
            <li>💡 Éclairage doux en journée</li>
            <li>🕰 Scénario préféré : “Éco Matin” (7h–10h)</li>
        </ul>
    </div>

</div>
@endsection

@section('scripts')
<script>
    lucide.createIcons();
</script>
@endsection
