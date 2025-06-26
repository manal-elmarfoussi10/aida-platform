@extends('layouts.app')

@section('title', 'Floorplan View')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold flex items-center gap-2"><i data-lucide="map"></i>Floorplan View</h1>
        <a href="{{ route('floorplan.create') }}"
   class="inline-flex items-center gap-2 px-6 py-3 bg-[#22c55e] hover:bg-[#16a34a] text-white text-base font-semibold rounded-lg shadow transition duration-200">
   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
   </svg>
   Add Room
</a>


    </div>

   <livewire:room-grid />

</div>
@endsection
