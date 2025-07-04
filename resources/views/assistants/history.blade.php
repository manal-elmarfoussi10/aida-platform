@extends('layouts.app')
@section('title', 'AI Request History')

@section('content')
<div class="max-w-3xl mx-auto py-10 text-white">
    <h2 class="text-2xl font-bold mb-6">History of AI Requests</h2>

    <ul class="space-y-4">
        @forelse($logs as $log)
            <li class="bg-[#222] p-4 rounded shadow">
                <p class="text-sm text-gray-400">Sent at: {{ $log->created_at->format('Y-m-d H:i') }}</p>
                <p class="mt-2"><strong>Prompt:</strong> {{ $log->message }}</p>
                <p class="mt-1"><strong>Response:</strong> {{ $log->response }}</p>
            </li>
        @empty
            <p class="text-gray-400">No previous AI requests found.</p>
        @endforelse
    </ul>
</div>
@endsection
