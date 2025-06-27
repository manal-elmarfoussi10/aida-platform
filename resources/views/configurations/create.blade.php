@extends('layouts.app')
@section('title', 'Create Configuration')

@section('content')
<div class="p-6 text-white">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-3xl font-bold">Create New Configuration</h2>
        <a href="{{ route('configurations.index') }}"
           class="text-sm bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
            ← Back to Configurations
        </a>
    </div>

    <form action="{{ route('configurations.store') }}" method="POST" class="bg-[#1e1e1e] p-6 rounded-lg shadow w-full max-w-3xl">
        @csrf

        <table class="w-full text-left">
            <tbody>
                {{-- Name --}}
                <tr class="border-b border-black-700">
                    <td class="py-4 pr-4 align-top font-semibold w-1/4">Name</td>
                    <td class="py-4">
                        <input type="text" name="name" required
                               class="w-full px-4 py-2 bg-[#333333] text-white rounded  focus:ring-2 focus:ring-green-400 focus:outline-none">
                    </td>
                </tr>

                {{-- Type --}}
                <tr class="border-b border-gray-700">
                    <td class="py-4 pr-4 align-top font-semibold">Type</td>
                    <td class="py-4">
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="Light" required>
                                <i data-lucide="lightbulb" class="w-5 h-5 text-yellow-400"></i> Light
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="HVAC">
                                <i data-lucide="snowflake" class="w-5 h-5 text-cyan-300"></i> HVAC
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="type" value="Shade">
                                <i data-lucide="blinds" class="w-5 h-5 text-blue-400"></i> Shade
                            </label>
                        </div>
                    </td>
                </tr>

                {{-- Mode --}}
                <tr class="border-b border-gray-700">
                    <td class="py-4 pr-4 align-top font-semibold">Mode</td>
                    <td class="py-4">
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="mode" value="Eco" required>
                                <i data-lucide="leaf" class="w-5 h-5 text-green-400"></i> Eco
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="mode" value="Performance">
                                <i data-lucide="zap" class="w-5 h-5 text-red-500"></i> Performance
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="mode" value="Standard">
                                <i data-lucide="gauge" class="w-5 h-5 text-blue-400"></i> Standard
                            </label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Submit --}}
        <div class="mt-6">
            <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-black font-semibold px-6 py-2 rounded shadow transition">
                Save Configuration
            </button>
        </div>
    </form>
</div>

{{-- Lucide icons --}}
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endsection
