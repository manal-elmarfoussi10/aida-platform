@extends('layouts.app')
@section('title', 'Add New Site')

@section('content')
<div class="p-8 max-w-3xl mx-auto text-white">
    <h2 class="text-3xl font-bold mb-6">Add New Site</h2>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="mb-4 bg-green-800 text-green-100 p-3 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-800 text-red-100 p-3 rounded shadow">
            <strong>Error:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Site Creation Form --}}
    <form action="{{ route('sites.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-[#1e1e1e] p-6 rounded-lg shadow-md space-y-5">
        @csrf

        {{-- Site Name --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Site Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500"
                   placeholder="e.g. Main Campus">
        </div>

        {{-- City --}}
        <div>
            <label class="block mb-2 text-sm font-medium">City</label>
            <input type="text" name="city" value="{{ old('city') }}"
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:ring-2 focus:ring-green-500"
                   placeholder="e.g. San Jose">
        </div>

        {{-- Upload Image File --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Upload Image</label>
            <input type="file" name="image_file"
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600">
        </div>

        {{-- OR Image URL --}}
        <div>
            <label class="block mb-2 text-sm font-medium">Or Enter Image URL</label>
            <input type="url" name="image_url" value="{{ old('image_url') }}"
                   class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600"
                   placeholder="https://example.com/image.jpg">
        </div>

        {{-- Submit Button --}}
        <div class="text-right">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-black font-semibold px-6 py-2 rounded transition-all shadow">
                Create Site
            </button>
        </div>
    </form>
</div>
@endsection