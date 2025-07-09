@extends('layouts.app')
@section('title', 'Add New Floor')

@section('content')
<div class="p-8 max-w-2xl mx-auto text-white">
    <h2 class="text-3xl font-bold mb-6">Add New Floor</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-800 text-red-100 p-3 rounded shadow">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('floors.store') }}" class="bg-[#1e1e1e] p-6 rounded shadow space-y-5">
        @csrf

        <div>
            <label class="block mb-2 text-sm font-medium">Building</label>
            <select name="building_id" required
                class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white focus:ring-2 focus:ring-green-500">
                <option value="">Select a building</option>
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}">{{ $building->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Floor Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white focus:ring-2 focus:ring-green-500"
                   placeholder="e.g. Ground Floor">
        </div>

        <div class="text-right">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-black font-semibold px-6 py-2 rounded transition shadow">
                Create Floor
            </button>
        </div>
    </form>
</div>
@endsection