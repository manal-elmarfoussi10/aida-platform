@extends('layouts.app')
@section('title', 'Add User')

@section('content')
<div class="p-6 text-white max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Add New User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4 bg-[#1f1f1f] p-4 rounded">
        @csrf
        <div>
            <label class="block text-sm">Name</label>
            <input type="text" name="name" required class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-600 text-white">
        </div>
        <div>
            <label class="block text-sm">Email</label>
            <input type="email" name="email" required class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-600 text-white">
        </div>
        <div>
            <label class="block text-sm">Password</label>
            <input type="password" name="password" required class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-600 text-white">
        </div>
        <div>
            <label class="block text-sm">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-600 text-white">
        </div>
        <div>
            <label class="block text-sm">Role</label>
            <select name="role" class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-600 text-white">
                <option value="admin">Admin</option>
                <option value="facility">Facility</option>
                <option value="user">User</option>
            </select>
        </div>
        <button type="submit" class="bg-green-500 px-4 py-2 rounded text-white">Create User</button>
    </form>
</div>
@endsection