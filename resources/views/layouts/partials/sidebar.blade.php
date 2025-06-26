@php
    $role = auth()->user()->role;
    $dashboardUrl = match($role) {
        'Admin' => url('/admin'),
        'Facility Manager' => url('/facility'),
        'User' => url('/user'),
        default => url('/dashboard'),
    };
@endphp

<aside class="w-64 bg-black text-white h-full flex flex-col">
    <div class="p-6">
        <!-- Logo -->
        <div class="flex items-center justify-center mb-6">
           <img src="{{ asset('images/logo aida.png') }}" alt="Aida-Logo" class="h-28 max-w-[160px] mx-auto">

        </div>

        <hr class="border-gray-700 mb-6">

        <!-- Navigation -->
        <nav class="space-y-2 text-sm font-medium">
            <a href="{{ $dashboardUrl }}" class="flex items-center px-4 py-2 rounded bg-[#1f1f1f] text-green-400">
                <i data-lucide="pie-chart" class="w-5 h-5 mr-3"></i> Dashboard
            </a>

            <a href="#" class="flex items-center px-4 py-2 hover:bg-[#1f1f1f] rounded text-gray-300">
                <i data-lucide="bar-chart-3" class="w-5 h-5 mr-3"></i> Zones
            </a>

            <a href="#" class="flex items-center px-4 py-2 hover:bg-[#1f1f1f] rounded text-gray-300 relative">
                <i data-lucide="sliders-horizontal" class="w-5 h-5 mr-3"></i> Control
                <span class="absolute right-4 top-2 bg-orange-400 text-xs text-black font-bold px-2 rounded-full">5</span>
            </a>

            <a href="#" class="flex items-center px-4 py-2 hover:bg-[#1f1f1f] rounded text-gray-300">
                <i data-lucide="users" class="w-5 h-5 mr-3"></i> Network
            </a>

            <div class="text-gray-400 mt-6 mb-2 text-xs px-4 uppercase tracking-wide">Shortcut</div>

            <a href="#" class="flex items-center px-4 py-2 hover:bg-[#1f1f1f] rounded text-gray-300">
                <i data-lucide="list" class="w-5 h-5 mr-3"></i> Configuration
            </a>

            <a href="#" class="flex items-center px-4 py-2 hover:bg-[#1f1f1f] rounded text-gray-300">
                <i data-lucide="alert-triangle" class="w-5 h-5 mr-3"></i> Reports
            </a>

            <a href="#" class="flex items-center px-4 py-2 hover:bg-[#1f1f1f] rounded text-gray-300">
                <i data-lucide="settings" class="w-5 h-5 mr-3"></i> Settings
            </a>
        </nav>
    </div>
</aside>
