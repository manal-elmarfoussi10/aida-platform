@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#121212] flex justify-center items-start py-10 px-4">
    <div class="w-full max-w-3xl md:w-[35%] text-white rounded-2xl space-y-6">

        <!-- Title -->
        <h1 class="text-2xl font-bold text-center">Settings</h1>

        <!-- Profile Card (Link) -->
        <a href="{{ route('settings.profile') }}" class="bg-[rgb(44,44,44)] rounded-2xl px-5 py-4 flex items-center justify-between shadow hover:bg-gray-700 transition">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <i data-lucide="user" class="w-5 h-5 text-black"></i>
                </div>
                <div>
                    <div class="font-semibold">Local Administrator</div>
                    <div class="text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
        </a>

        <!-- Settings Group -->
        <div class="bg-[rgb(44,44,44)] rounded-2xl px-5 py-4 space-y-5 shadow">

            <!-- Location -->
            <a href="{{ route('settings.location') }}" class="flex items-center justify-between hover:bg-gray-700 transition px-3 py-2 rounded-lg">
                <div class="flex items-center gap-4">
                    <i data-lucide="globe" class="w-5 h-5"></i>
                    <div>
                        <div class="text-sm">Location</div>
                        <div class="text-xs text-gray-400">{{ $settings->location ?? 'Not set' }}</div>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
            </a>

            <!-- Notifications -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    <div class="text-sm">Notifications</div>
                </div>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" {{ $settings->notifications ? 'checked' : '' }}>
                    <div class="w-10 h-5 bg-gray-600 rounded-full peer peer-checked:bg-green-500 transition relative">
                        <div class="absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full peer-checked:translate-x-5 transition"></div>
                    </div>
                </label>
            </div>

            <!-- Language -->
            <a href="{{ route('settings.language') }}" class="flex items-center justify-between hover:bg-gray-700 transition px-3 py-2 rounded-lg">
                <div class="flex items-center gap-4">
                    <i data-lucide="languages" class="w-5 h-5"></i>
                    <div>
                        <div class="text-sm">Language</div>
                        <div class="text-xs text-gray-400">{{ $settings->language ?? 'EN' }}</div>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
            </a>

            <!-- Software Upgrade -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <i data-lucide="upload" class="w-5 h-5"></i>
                    <div class="text-sm">Software upgrade</div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
            </div>

            <!-- Dark Mode -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <i data-lucide="moon" class="w-5 h-5"></i>
                    <div class="text-sm">Dark mood</div>
                </div>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" {{ $settings->dark_mode ? 'checked' : '' }}>
                    <div class="w-10 h-5 bg-gray-600 rounded-full peer peer-checked:bg-green-500 transition relative">
                        <div class="absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full peer-checked:translate-x-5 transition"></div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Help -->
        <div class="bg-[rgb(44,44,44)] rounded-2xl px-5 py-4 flex items-center justify-between shadow">
            <div class="flex items-center gap-4">
                <i data-lucide="help-circle" class="w-5 h-5"></i>
                <div class="text-sm">Help</div>
            </div>
            <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full bg-[rgb(44,44,44)] rounded-2xl px-5 py-4 flex items-center justify-between shadow hover:bg-gray-700 transition">
                <div class="flex items-center gap-4">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <div class="text-sm">Log out</div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
            </button>
        </form>

        <!-- Version -->
        <div class="text-right text-xs text-gray-500 pr-2">
            Version 8.2.12
        </div>
    </div>
</div>

<!-- Init Lucide -->
<script>
    lucide.createIcons();
</script>
@endsection