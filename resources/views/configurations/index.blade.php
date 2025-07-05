@extends('layouts.app')
@section('title', 'Configurations')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold tracking-wide">Configurations</h2>
        <a href="{{ route('configurations.create') }}"
           class="bg-green-500 text-black px-5 py-2 rounded hover:bg-green-400 shadow-lg transition-all">
            Create New Configuration
        </a>
    </div>

    <div class="relative w-1/3 mb-6">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i data-lucide="search" class="w-4 h-4"></i>
        </span>
        <input type="text" placeholder="Search configurations..."
               class="h-10 text-sm pl-10 pr-4 py-2 w-full bg-[#333333] text-white border border-gray-600 rounded placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-400">
    </div>

    <div class="bg-[#1e1e1e] rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#333333] text-whit-300 text-sm font-medium">
                <tr>
                    <th class="px-6 py-3">Configuration Name</th>
                    <th class="px-6 py-3">Type</th>
                    <th class="px-6 py-3">Assigned Zones</th>
                    <th class="px-6 py-3">Mode</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($configs as $config)
                <tr class="border-b border-gray-700 hover:bg-[#2a2a2a] transition">
                    <td class="px-6 py-4">{{ $config->name }}</td>
                    <td class="px-6 py-4 flex items-center gap-2">
                        @if($config->type === 'Light')
                            <i data-lucide="lightbulb" class="w-5 h-5 text-yellow-400"></i> Light
                        @elseif($config->type === 'HVAC')
                            <i data-lucide="snowflake" class="w-5 h-5 text-cyan-300"></i> HVAC
                        @elseif($config->type === 'Shade')
                            <i data-lucide="blinds" class="w-5 h-5 text-blue-400"></i> Shade
                        @else
                            {{ $config->type }}
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($config->zones && $config->zones->count())
                            @foreach($config->zones as $zone)
                                <span class="inline-block bg-gray-700 text-white text-xs px-3 py-1 rounded-full mr-1">
                                    {{ $zone->name }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-gray-400">No Zones</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 flex items-center gap-2">
                        @if($config->mode === 'Eco')
                            <i data-lucide="leaf" class="w-5 h-5 text-green-400"></i> Eco
                        @elseif($config->mode === 'Performance')
                            <i data-lucide="zap" class="w-5 h-5 text-red-400"></i> Performance
                        @elseif($config->mode === 'Standard')
                            <i data-lucide="gauge" class="w-5 h-5 text-white"></i> Standard
                        @else
                            {{ $config->mode }}
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center items-center gap-4">
                            <a href="{{ route('configurations.edit', $config->id) }}" class="text-green-400 hover:text-green-300">
                                <i data-lucide="pencil" class="w-5 h-5"></i>
                            </a>
                            <form method="POST" action="{{ route('configurations.destroy', $config->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection