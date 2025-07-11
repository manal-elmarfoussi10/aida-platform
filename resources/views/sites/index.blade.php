@extends('layouts.app')
@section('title', 'Sites List')

@section('content')
<div class="p-6 text-white">
    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600 text-black rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header + Add Button --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold tracking-wide">Sites List</h2>
        <a href="{{ route('sites.create') }}"
           class="bg-green-500 text-black px-5 py-2 rounded hover:bg-green-400 shadow-lg transition-all">
            Add New Site
        </a>
    </div>

    {{-- Search Bar --}}
    <div class="relative w-1/3 mb-6">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i data-lucide="search" class="w-4 h-4"></i>
        </span>
        <input type="text" placeholder="Search sites..."
               class="h-10 text-sm pl-10 pr-4 py-2 w-full bg-gray-800 text-white border border-gray-600 rounded placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-400">
    </div>

    {{-- Table --}}
    <div class="bg-[#1e1e1e] rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#2a2a2a] text-white">
                <tr>
                    <th class="px-4 py-3 font-semibold">Site Name</th>
                    <th class="px-4 py-3 font-semibold">City</th>
                    <th class="px-4 py-3 font-semibold">Buildings Count</th>
                    <th class="px-4 py-3 font-semibold text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sites as $site)
                <tr class="border-b border-white hover:bg-[#2a2a2a] transition-all">
                    <td class="px-4 py-3">{{ $site->name }}</td>
                    <td class="px-4 py-3">{{ $site->city ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $site->buildings_count ?? $site->buildings->count() }}</td>
                    <td class="px-4 py-3 text-center flex justify-center gap-3">
                        {{-- Edit --}}
                        <a href="{{ route('sites.edit', $site) }}" class="text-blue-400 hover:text-blue-600">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('sites.destroy', $site) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this site?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600">
                                <i data-lucide="trash" class="w-4 h-4"></i>
                            </button>
                        </form>

                        {{-- Optional: Show --}}
                        {{-- 
                        <a href="{{ route('sites.show', $site) }}" class="text-green-400 hover:text-green-600">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        --}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">No sites available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (window.lucide) {
            window.lucide.createIcons();
        }
    });
</script>
@endpush
