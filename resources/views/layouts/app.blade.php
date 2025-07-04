<!DOCTYPE html>
<html lang="en">
    @livewireStyles

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Aida')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Chart.js + Icons -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://unpkg.com/lucide@latest/dist/lucide.js"></script>
    @livewireStyles

</head>
@livewireScripts

<body class="bg-[#0f0f0f] text-white flex h-screen">

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <!-- Main Content -->
    <div class="flex flex-col flex-1 overflow-hidden">
        @include('layouts.partials.header')

        <main class="p-6 overflow-y-auto bg-[#1a1a1a] flex-1">
            @yield('content')
        </main>
    </div>

    <!-- Init Lucide Icons -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });
    </script>

    <!-- Scripts from specific pages -->
    @stack('scripts')
    @yield('scripts')
    @stack('scripts')
    @livewireScripts
</body>
</html>
