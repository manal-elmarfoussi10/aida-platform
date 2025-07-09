@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#121212] text-white px-4 py-8">

    <!-- Title -->
    <h1 class="text-2xl font-bold mb-6">Reports & Features</h1>

    <!-- AI Report Assistant Box -->
    <div class="bg-[rgb(44,44,44)] rounded-2xl p-5 mb-6 shadow space-y-4">
        <div class="flex items-center gap-3">
            <div class="bg-green-500 text-black p-2 rounded-full">
                <i data-lucide="bot" class="w-5 h-5"></i>
            </div>
            <div class="font-semibold text-lg">AI Report Assistant</div>
        </div>

        <!-- Welcome bubble -->
        <div class="bg-green-500 text-black rounded-xl px-4 py-2 text-sm w-fit">
            Welcome! Ask me about your building's reports or features.
        </div>

        <!-- Suggested Actions -->
        <div class="flex flex-wrap gap-2">
            @foreach (['Show system health', 'Summarize security status', 'List offline features', 'Show compliance summary'] as $action)
                <button onclick="document.getElementById('aiInput').value='{{ $action }}'" class="bg-[#2c2c2c] hover:bg-[#3a3a3a] px-4 py-1 rounded-full text-sm">
                    {{ $action }}
                </button>
            @endforeach
        </div>

        <!-- Input Box -->
        <div class="relative">
            <input type="text" id="aiInput" class="bg-[#1a1a1a] border border-gray-700 w-full px-4 py-2 rounded-xl pr-10 text-sm"
                   placeholder="Ask about reports or features...">
            <button id="aiSend" class="absolute right-3 top-1/2 -translate-y-1/2 text-green-500">
                <i data-lucide="send" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Reply Display -->
        <div id="aiResponse" class="mt-3 text-sm text-gray-300"></div>
    </div>

     <!-- Feature Cards -->
     <div class="grid md:grid-cols-3 gap-6">
        <!-- Sample Card -->
        @php
            $features = [
                [
                    'icon' => 'eye',
                    'title' => 'Vision Systems',
                    'status' => 'Operational',
                    'status_color' => 'bg-green-500',
                    'substatus' => '12/12 cameras online',
                    'substatus_color' => 'text-green-400',
                    'description' => 'Camera-based room and device inspection for advanced automation.'
                ],
                [
                    'icon' => 'hand-pointer',
                    'title' => 'Touch Sensors',
                    'status' => 'Warning',
                    'status_color' => 'bg-yellow-500',
                    'substatus' => '2 sensors need calibration',
                    'substatus_color' => 'text-green-400',
                    'description' => 'Physical equipment verification with tactile feedback.'
                ],
                [
                    'icon' => 'temperature-half',
                    'title' => 'Environmental Monitoring',
                    'status' => 'Operational',
                    'status_color' => 'bg-green-500',
                    'substatus' => 'All zones normal',
                    'substatus_color' => 'text-green-400',
                    'description' => 'Real-time temperature and humidity feedback for comfort and safety.'
                ],
                [
                    'icon' => 'microphone',
                    'title' => 'Voice Interface',
                    'status' => 'Offline',
                    'status_color' => 'bg-red-500',
                    'substatus' => 'Voice module updating',
                    'substatus_color' => 'text-green-400',
                    'description' => 'Natural language reporting and control for hands-free operation.'
                ],
                [
                    'icon' => 'person-running',
                    'title' => 'On-Demand Dispatch',
                    'status' => 'Idle',
                    'status_color' => 'bg-green-500',
                    'substatus' => 'Last dispatch: 2h ago',
                    'substatus_color' => 'text-green-400',
                    'description' => 'Facility manager-controlled robot deployment for rapid response.'
                ],
                [
                    'icon' => 'bolt',
                    'title' => 'Real-time Response',
                    'status' => 'Optimal',
                    'status_color' => 'bg-green-500',
                    'substatus' => 'Avg: 87ms',
                    'substatus_color' => 'text-green-400',
                    'description' => '< 100ms for device control and automation actions.'
                ]
            ];
        @endphp

        @foreach ($features as $feature)
        <div class="bg-[#2c2c2c] rounded-2xl p-5 shadow">
            <div class="flex justify-between items-start">
                <div class="w-10 h-10 rounded-full bg-black flex items-center justify-center mb-3">
                    <i class="fa-solid fa-{{ $feature['icon'] }} text-white"></i>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $feature['status_color'] }} text-black font-semibold">
                    {{ $feature['status'] }}
                </span>
            </div>
            <h3 class="text-lg font-semibold mb-1">{{ $feature['title'] }}</h3>
            <div class="text-sm font-semibold {{ $feature['substatus_color'] }} mb-1">
                {{ $feature['substatus'] }}
            </div>
            <p class="text-xs text-gray-400">{{ $feature['description'] }}</p>
        </div>
        @endforeach
    </div>
</div>

<script>
    // Load Lucide icons
    lucide.createIcons();

    // Handle AI Assistant Send
    document.getElementById('aiSend').addEventListener('click', async function () {
        const input = document.getElementById('aiInput');
        const responseBox = document.getElementById('aiResponse');

        if (!input.value.trim()) return;

        responseBox.innerHTML = "Thinking...";

        const res = await fetch("{{ route('ai.reports.respond') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ prompt: input.value })
        });

        const data = await res.json();
        responseBox.innerHTML = `<div class="text-green-400 mb-1">AI:</div><div>${data.reply}</div>`;
    });
</script>
@endsection