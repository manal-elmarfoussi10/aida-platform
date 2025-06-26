@extends('layouts.app')

@section('title', 'Edit Room')

@section('content')
<div class="p-6 max-w-md mx-auto">
    <h2 class="text-xl font-bold mb-4 text-white">Edit {{ $room->name }}</h2>

    <form method="POST" action="{{ route('rooms.update', $room) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-white mb-1">Room Name</label>
            <input type="text" name="name" value="{{ $room->name }}" class="w-full px-3 py-2 rounded bg-gray-800 text-white">
        </div>

        <button class="bg-blue-500 px-4 py-2 rounded text-white">Update</button>
    </form>
</div>
@endsection
