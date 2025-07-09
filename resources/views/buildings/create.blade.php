@extends('layouts.app')
@section('title', 'Add New Building')

@section('content')
<div class="p-6 text-white">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold tracking-wide">Add New Building</h2>
        <a href="{{ route('buildings.index') }}" class="text-white hover:underline">← Back to List</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-600 text-white rounded shadow">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('buildings.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="site_id" class="block mb-1">Site</label>
            <select name="site_id" id="site_id"
                class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white">
                <option value="">-- Select Site --</option>
                @foreach($sites as $site)
                    <option value="{{ $site->id }}" {{ old('site_id') == $site->id ? 'selected' : '' }}>
                        {{ $site->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="name" class="block mb-1">Building Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white">
        </div>

        <div>
            <label for="type" class="block mb-1">Type</label>
            <input type="text" name="type" id="type" value="{{ old('type') }}"
                class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded text-white">
        </div>

     

  

        <button type="submit"
            class="bg-green-600 text-black px-6 py-2 rounded hover:bg-green-500 transition">
            Create Building
        </button>
    </form>
</div>
@endsection