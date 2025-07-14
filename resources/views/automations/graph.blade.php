@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 text-white">
    <h1 class="text-2xl font-bold mb-4">Automation Graph</h1>

    {{-- Composant Vue FlowEditor --}}
    <div id="app">
        <flow-editor :automation-id="{{ $id }}"></flow-editor>
    </div>
</div>
@endsection
