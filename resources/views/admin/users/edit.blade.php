@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="p-6 text-white max-w-2xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-3xl font-bold">Edit User</h2>
        <p class="text-gray-400">Update details for <strong>{{ $user->name }}</strong></p>
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-green-500">
            @error('name')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-green-500">
            @error('email')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role --}}
        <div>
            <label for="role" class="block text-sm font-medium mb-1">Role</label>
            <select name="role" id="role"
                    class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-green-500">
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="facility" {{ old('role', $user->role) == 'facility' ? 'selected' : '' }}>Facility</option>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
            </select>
            @error('role')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password (Optional) --}}
        <div>
            <label for="password" class="block text-sm font-medium mb-1">Password <span class="text-gray-400">(leave blank to keep current)</span></label>
            <input type="password" name="password" id="password"
                   class="w-full px-4 py-2 bg-gray-800 text-white border border-gray-600 rounded focus:ring-2 focus:ring-green-500">
            @error('password')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.users.index') }}"
               class="text-sm text-gray-400 hover:text-white">← Back to Users</a>
            <button type="submit"
                    class="bg-green-500 hover:bg-green-400 text-black px-5 py-2 rounded shadow">
                Update User
            </button>
        </div>
    </form>
</div>
@endsection