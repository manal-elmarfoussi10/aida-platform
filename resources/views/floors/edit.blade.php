@extends('layouts.app')
@section('title', 'Edit Floor')

@section('content')
<div class="p-8 max-w-2xl mx-auto text-white">
    <h2 class="text-3xl font-bold mb-6">Edit Floor</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-800 text-red-100 p-3 rounded shadow">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('floors.update', $floor) }}" class="bg-[#1e1e1e] p-6 rounded shadow space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-2 text-sm font-medium">Building</label>
            <select name="building_id" required
                class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white focus:ring-2 focus:ring-green-500">
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}" {{ $floor->building_id == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium">Floor Name</label>
            <input type="text" name="name" value="{{ old('name', $floor->name) }}" required
                   class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white focus:ring-2 focus:ring-green-500">
        </div>

        <div class="text-right">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-black font-semibold px-6 py-2 rounded transition shadow">
                Update Floor
            </button>
        </div>
    </form>
</div>
@endsection