@extends('layouts.app')

@section('content')
<div class="p-6 min-h-screen text-white">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Schedule Calendar</h1>
        <a href="{{ route('schedules.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            + Add Schedule
        </a>
    </div>

    <div id="calendar" class="bg-zinc-900 p-4 rounded-lg shadow-md"></div>
</div>

{{-- FullCalendar --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'standard',
            height: 'auto',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '{{ route('schedules.events') }}',
            eventColor: '#22c55e',
            nowIndicator: true,
            timeZone: 'UTC',
        });

        calendar.render();
    });
</script>
@endsection