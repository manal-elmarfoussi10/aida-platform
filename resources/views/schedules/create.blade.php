@section('content')
<div class="p-6 text-white">
    <h2 class="text-2xl font-bold mb-6">Create New Schedule</h2>
    <form method="POST" action="{{ route('schedules.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 text-sm">Select Device</label>
            <select name="device_id" class="w-full p-2 bg-gray-800 border border-gray-600 rounded">
                <option value="">Choose a device</option>
                @foreach($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->device_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-sm">Action</label>
            <select name="action" class="w-full p-2 bg-gray-800 border border-gray-600 rounded">
                <option value="on">Turn ON</option>
                <option value="off">Turn OFF</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 text-sm">Scheduled Time</label>
            <input type="datetime-local" name="scheduled_at" class="w-full p-2 bg-gray-800 border border-gray-600 rounded">
        </div>

        <button type="submit" class="bg-green-500 px-4 py-2 rounded text-black">Save Schedule</button>
    </form>
</div>
@endsection