@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#121212] flex justify-center items-start py-10 px-4">
    <form method="POST" action="{{ url('/settings/profile') }}" class="w-full max-w-md bg-[rgb(44,44,44)] text-white p-6 rounded-2xl space-y-4 shadow">
        @csrf
        <h2 class="text-xl font-semibold mb-4">Edit Profile</h2>

        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-800 text-white px-3 py-2 rounded-lg mt-1">
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-800 text-white px-3 py-2 rounded-lg mt-1">
        </div>

        <div>
            <label>New Password</label>
            <input type="password" name="password" class="w-full bg-gray-800 text-white px-3 py-2 rounded-lg mt-1">
        </div>

        <button class="bg-green-500 text-black px-4 py-2 rounded-lg">Save</button>
    </form>
</div>
@endsection