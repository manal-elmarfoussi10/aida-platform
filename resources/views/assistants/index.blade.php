@extends('layouts.app')

@section('title', 'Assistants')

@section('content')
<div class="max-w-screen-xl mx-auto px-6 py-8 text-white space-y-6">
    <h2 class="text-2xl font-bold">Assistants</h2>

    <!-- AI Assistant -->
    <div class="bg-[#1f1f1f] rounded-xl p-6 shadow space-y-4">
        <div class="flex items-center gap-3 text-lg font-semibold text-green-400">
            <i data-lucide="bot" class="w-5 h-5"></i>
            AI Assistant
        </div>
        <div class="bg-[#111] rounded-lg p-4 min-h-[100px]">
            <p class="text-green-400">Hello! How can I assist you today?</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button class="bg-[#333] px-4 py-1 rounded text-sm">Show energy usage</button>
            <button class="bg-[#333] px-4 py-1 rounded text-sm">Optimize HVAC</button>
            <button class="bg-[#333] px-4 py-1 rounded text-sm">Report maintenance</button>
            <button class="bg-[#333] px-4 py-1 rounded text-sm">Summarize alerts</button>
        </div>
        <form class="flex items-center bg-[#111] rounded px-2 py-1 mt-2">
            <input type="text" placeholder="Type your request..." class="w-full bg-transparent border-none text-sm px-2 py-1 focus:outline-none">
            <button type="submit" class="text-green-400 text-xl px-2">&#9658;</button>
        </form>
    </div>

    <!-- Humanoid + Ecosystem -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Humanoid Assistant -->
        <div class="bg-[#1f1f1f] rounded-xl p-6 shadow space-y-4">
            <div class="flex items-center gap-3 text-lg font-semibold">
                <i class="w-6 h-6 text-green-400" data-lucide="robot"></i>
                Humanoid Assistant
            </div>
            <p class="text-sm text-gray-300">The humanoid assistant can be dispatched for physical tasks, inspections, or guided tours.</p>
            <span class="bg-green-500 text-black text-xs px-2 py-1 rounded">Online</span>
            <button class="bg-green-500 text-black px-4 py-2 rounded mt-2 flex items-center gap-1">
                <i data-lucide="search" class="w-4 h-4"></i> Dispatch
            </button>
        </div>

        <!-- Ecosystem Assistant -->
        <div class="bg-[#1f1f1f] rounded-xl p-6 shadow space-y-4">
            <div class="flex items-center gap-3 text-lg font-semibold">
                <i class="w-6 h-6 text-gray-400" data-lucide="network"></i>
                Ecosystem Assistant
            </div>
            <p class="text-sm text-gray-300">Integrate with third-party platforms and explore the Aida ecosystem.</p>
            <ul class="text-sm space-y-1">
                <li><i data-lucide="phone" class="w-4 h-4 inline text-green-400"></i> Cisco Switch</li>
                <li><i data-lucide="mic" class="w-4 h-4 inline text-green-400"></i> Google Assistant</li>
                <li><i data-lucide="puzzle" class="w-4 h-4 inline text-green-400"></i> Marketplace</li>
            </ul>
            <button class="bg-green-500 text-black px-4 py-2 rounded mt-2 flex items-center gap-1">
                <i data-lucide="puzzle" class="w-4 h-4"></i> Explore Integrations
            </button>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
<script>
    Echo.channel('assistants')
        .listen('AssistantStatusUpdated', (e) => {
            const status = e.assistant.status;
            document.getElementById('humanoid-status').innerText = status;
        });
</script>

@endsection
