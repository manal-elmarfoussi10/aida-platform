@extends('layouts.app')
@section('title', 'Edit Building')

@section('content')
<div class="p-6 text-white">
    {{-- Validation Error --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-600 text-white rounded shadow">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Edit Building</h2>
        <a href="{{ route('buildings.index') }}"
           class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Back to List
        </a>
    </div>

    {{-- Edit Form --}}
    <form action="{{ route('buildings.update', $building) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Site --}}
        <div>
            <label for="site_id" class="block text-sm font-medium mb-1">Site</label>
            <select id="site_id" name="site_id" class="w-full bg-gray-800 text-white rounded border border-gray-600 px-4 py-2">
                <option value="">Select Site</option>
                @foreach ($sites as $site)
                    <option value="{{ $site->id }}" {{ $building->site_id == $site->id ? 'selected' : '' }}>
                        {{ $site->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Building Name --}}
        <div>
            <label for="name" class="block text-sm font-medium mb-1">Building Name</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $building->name) }}"
                   class="w-full bg-gray-800 text-white rounded border border-gray-600 px-4 py-2">
        </div>

        {{-- Type --}}
        <div>
            <label for="type" class="block text-sm font-medium mb-1">Type</label>
            <input type="text" name="type" id="type"
                   value="{{ old('type', $building->type) }}"
                   class="w-full bg-gray-800 text-white rounded border border-gray-600 px-4 py-2">
        </div>

     

      

        {{-- Submit Button --}}
        <div>
            <button type="submit"
                    class="bg-green-600 text-black px-6 py-2 rounded hover:bg-green-500 transition">
                Update Building
            </button>
        </div>
    </form>
</div>
@endsection