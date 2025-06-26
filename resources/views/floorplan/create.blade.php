@extends('layouts.app')

@section('title', 'Add Room')

@section('content')
<div class="p-6 max-w-lg mx-auto text-white">
    <h1 class="text-2xl font-bold mb-4">➕ Add New Room</h1>

    <form method="POST" action="{{ route('floorplan.store') }}" class="space-y-4 bg-[#1f1f1f] p-4 rounded">
        @csrf
        <div>
            <label class="block mb-1">Room Name</label>
            <input type="text" name="name" class="w-full p-2 rounded bg-black text-white border border-gray-700" required>
        </div>

        <button type="submit" class="bg-green-500 px-4 py-2 rounded hover:bg-green-600">Add Room</button>
    </form>
</div>
@endsection
