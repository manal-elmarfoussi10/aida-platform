@extends('layouts.app')
@section('title', 'Floors List')

@section('content')
<div class="p-6 text-white">
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600 text-black rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Floors List</h2>
        <a href="{{ route('floors.create') }}"
           class="bg-green-500 text-black px-5 py-2 rounded hover:bg-green-400 shadow transition">
            Add New Floor
        </a>
    </div>

    <div class="bg-[#1e1e1e] rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#2a2a2a] text-white">
                <tr>
                    <th class="px-4 py-3">Floor Name</th>
                    <th class="px-4 py-3">Building</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($floors as $floor)
                    <tr class="border-b border-white hover:bg-[#2a2a2a] transition">
                        <td class="px-4 py-3">{{ $floor->name }}</td>
                        <td class="px-4 py-3">{{ $floor->building->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center flex justify-center gap-3">
                            <a href="{{ route('floors.edit', $floor) }}" class="text-green-400 hover:text-green-600">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('floors.destroy', $floor) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-6 text-gray-500">No floors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection