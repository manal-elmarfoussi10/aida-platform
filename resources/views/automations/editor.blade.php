@extends('layouts.app')

@section('content')
    <!-- Zone selection -->
    <div id="zoneForm">
        <select id="zoneSelect" class="text-black px-4 py-2 rounded">
            @foreach ($zones as $zone)
                <option value="{{ $zone->id }}">{{ $zone->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Vue mount point -->
    <div id="app">
        <editor :initial-zone="{{ $zones->first()->id }}"></editor>
    </div>
@endsection