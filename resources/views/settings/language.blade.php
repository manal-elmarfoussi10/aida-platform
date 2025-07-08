@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#121212] flex justify-center items-start py-10 px-4">
    <form method="POST" action="{{ url('/settings/language') }}" class="w-full max-w-md bg-[rgb(44,44,44)] text-white p-6 rounded-2xl space-y-4 shadow">
        @csrf
        <h2 class="text-xl font-semibold mb-4">Edit Language</h2>

        <div>
            <label>Language</label>
            <select name="language" class="w-full bg-gray-800 text-white px-3 py-2 rounded-lg mt-1">
                <option value="EN" {{ ($settings->language ?? '') == 'EN' ? 'selected' : '' }}>English</option>
                <option value="ES" {{ ($settings->language ?? '') == 'ES' ? 'selected' : '' }}>Spanish</option>
                <option value="FR" {{ ($settings->language ?? '') == 'FR' ? 'selected' : '' }}>French</option>
            </select>
        </div>

        <button class="bg-green-500 text-black px-4 py-2 rounded-lg">Save</button>
    </form>
</div>
@endsection