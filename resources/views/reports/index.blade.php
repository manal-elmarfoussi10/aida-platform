@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#121212] text-white px-6 py-10">
    <h1 class="text-3xl font-bold mb-6">Reports & Features</h1>

    <!-- AI Assistant -->
    <div class="bg-[#2c2c2c] rounded-2xl p-5 mb-10 shadow">
        <div class="flex items-center mb-4 gap-3">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-robot text-black"></i>
            </div>
            <h2 class="text-xl font-semibold">AI Report Assistant</h2>
        </div>

        <div class="bg-[#1b1b1b] rounded-xl p-4 text-sm text-green-300 mb-4">
            Welcome! Ask me about your building’s reports or features.
        </div>

        <div class="flex flex-wrap gap-3 mb-4">
            <button class="px-4 py-1 bg-[#1f1f1f] rounded-full text-sm">Show system health</button>
            <button class="px-4 py-1 bg-[#1f1f1f] rounded-full text-sm">Summarize security status</button>
            <button class="px-4 py-1 bg-[#1f1f1f] rounded-full text-sm">List offline features</button>
            <button class="px-4 py-1 bg-[#1f1f1f] rounded-full text-sm">Show compliance summary</button>
        </div>

        <form method="POST" action="{{ route('ai.reports.respond') }}" class="flex items-center bg-[#1f1f1f] rounded-xl">
            @csrf
            <input type="text" name="message" placeholder="Ask about reports or features..." class="w-full bg-transparent px-4 py-3 text-sm focus:outline-none" />
            <button type="submit" class="px-4">
                <i class="fa-solid fa-paper-plane text-green-500"></i>
            </button>
        </form>
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
@endsection