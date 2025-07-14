@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4 px-6">
        <h1 class="text-2xl font-bold text-white">Automation Logic</h1>
        <a href="{{ route('automations.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            ➕ Create New Automation
        </a>
    </div>

    <!-- Vue mount point -->
    <div id="app">
        <editor></editor>
    </div>
@endsection
