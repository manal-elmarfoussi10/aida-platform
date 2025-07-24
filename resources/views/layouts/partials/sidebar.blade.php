@php
    $role = auth()->user()->role;
    $dashboardUrl = match($role) {
        'Admin' => url('/admin'),
        'Facility Manager' => url('/facility'),
        'User' => url('/user'),
        default => url('/dashboard'),
    };

    function isActive($pattern) {
        return request()->is($pattern) ? 'text-green-400 bg-[#1f1f1f]' : 'text-white hover:text-green-400';
    }

    $isHierarchyOpen = request()->is('hierarchy*') || request()->is('sites*') || request()->is('buildings*') || request()->is('floors*');
@endphp

<aside class="w-64 bg-black text-white h-full flex flex-col">
    <!-- Logo -->
    <div class="pt-6 pb-4 flex justify-center items-center">
        <img src="{{ asset('images/LOGOAIDAA.png') }}" alt="Aida Logo" class="h-36 w-auto max-w-[220px] object-contain">
    </div>

    <hr class="border-gray-600 mb-4 mx-4">

    <nav class="space-y-1 text-sm font-medium px-2 flex-1">
        <a href="{{ $dashboardUrl }}" class="flex items-center px-4 py-3 rounded {{ isActive('admin') }} {{ isActive('facility') }} {{ isActive('user') }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i> Dashboard
        </a>

        @if (in_array($role, ['Admin', 'Facility Manager', 'User']))
        <a href="{{ route('assistants.chat') }}" class="flex items-center px-4 py-3 rounded {{ isActive('assistants/chat') }}">
            <i data-lucide="bot" class="w-5 h-5 mr-3"></i> Assistant
        </a>
        @endif

        @if (in_array($role, ['Admin', 'Facility Manager']))
        <a href="{{ route('controls.index') }}" class="flex items-center px-4 py-3 rounded {{ isActive('controls*') }}">
            <i data-lucide="wifi" class="w-5 h-5 mr-3"></i> Control
        </a>
        @endif


        @if (in_array($role, ['Admin', 'Facility Manager']))
        <a href="{{ route('devices.index') }}" class="flex items-center px-4 py-3 rounded {{ isActive('devices*') }}">
            <i data-lucide="tablet" class="w-5 h-5 mr-3"></i> Devices
        </a>
        @endif

        <a href="{{ route('zones-v2.index') }}" class="flex items-center px-4 py-3 rounded {{ isActive('zones-v2*') }}">
            <i data-lucide="map" class="w-5 h-5 mr-3"></i> Zones
        </a>

        @if ($role !== 'User')
        <a href="{{ route('network.index') }}" class="flex items-center px-4 py-3 rounded {{ isActive('network-devices*') }}">
            <i data-lucide="cpu" class="w-5 h-5 mr-3"></i> Network
        </a>

        <a href="{{ route('configurations.index') }}" class="flex items-center px-4 py-3 rounded {{ isActive('configurations*') }}">
            <i data-lucide="sliders" class="w-5 h-5 mr-3"></i> Configuration
        </a>

        @endif


        @if ($role !== 'User')
        <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 rounded {{ isActive('reports*') }}">
            <i data-lucide="bar-chart-2" class="w-5 h-5 mr-3"></i> Reports
        </a>
        @endif

        @if ($role !== 'User')
        <a href="{{ route('settings') }}" class="flex items-center px-4 py-3 rounded {{ isActive('settings*') }}">
            <i data-lucide="settings" class="w-5 h-5 mr-3"></i> Settings
        </a>
        @endif

        <!-- Hierarchy -->
        @if (in_array($role, ['Admin', 'Facility Manager', 'User']))
        <div class="space-y-1">
            <a href="{{ route('hierarchy.index') }}" class="flex items-center px-4 py-3 rounded {{ $isHierarchyOpen ? 'text-green-400 bg-[#1f1f1f]' : 'text-white hover:text-green-400' }}">
                <i data-lucide="git-branch" class="w-5 h-5 mr-3"></i> Hierarchy
            </a>
            @if ($isHierarchyOpen)
                <div class="ml-8 space-y-1">
                    <a href="{{ route('sites.index') }}" class="block px-4 py-2 rounded {{ isActive('sites*') }}">Sites</a>
                    <a href="{{ route('buildings.index') }}" class="block px-4 py-2 rounded {{ isActive('buildings*') }}">Buildings</a>
                    <a href="{{ route('floors.index') }}" class="block px-4 py-2 rounded {{ isActive('floors*') }}">Floors</a>
                </div>
            @endif
        </div>
        @endif
    </nav>

    <!-- User Footer -->
    <div class="px-4 py-4 border-t border-gray-700 flex items-center space-x-3">
        <div class="bg-green-600 w-10 h-10 rounded-full flex items-center justify-center">
            <i data-lucide="user" class="text-white w-5 h-5"></i>
        </div>
        <div>
            <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
            <div class="text-xs text-gray-400">{{ auth()->user()->role }}</div>
        </div>
    </div>
</aside>
