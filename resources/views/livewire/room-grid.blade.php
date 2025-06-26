<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
    @foreach ($rooms as $room)
       <div class="rounded-xl border p-5 relative hover:shadow-xl transition duration-300
    {{ $room->light_on ? 'bg-emerald-800/80 border-emerald-500 ring-2 ring-emerald-400' : 'bg-white/5 border-gray-700' }}">

            {{-- Status Badge --}}
            <div class="absolute top-3 right-3">
                <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium rounded-full
                    {{ $room->light_on ? 'bg-green-600 text-white' : 'bg-gray-600 text-gray-300' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11 3a1 1 0 10-2 0v4a1 1 0 102 0V3zM4.22 5.64a1 1 0 10-1.44 1.44l2.83 2.83a1 1 0 101.44-1.44L4.22 5.64zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zm13.78-5.36a1 1 0 00-1.44 0l-2.83 2.83a1 1 0 001.44 1.44l2.83-2.83a1 1 0 000-1.44zM13 11a1 1 0 000 2h4a1 1 0 100-2h-4z" />
                    </svg>
                    {{ $room->light_on ? 'Active' : 'Inactive' }}
                </span>
            </div>

            {{-- Title --}}
            <div class="flex items-center mb-4">
                <svg class="h-6 w-6 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10l9-7 9 7v8a2 2 0 01-2 2h-2a2 2 0 01-2-2V12H9v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-8z" />
                </svg>
                <h3 class="text-lg font-bold text-white">{{ $room->name }}</h3>
            </div>

            {{-- Stats --}}
            <ul class="space-y-2 text-sm text-gray-300">
                <li class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v12m0 0l-3-3m3 3l3-3" />
                    </svg>
                    Light:
                    <span class="{{ $room->light_on ? 'text-green-400' : 'text-red-400' }}">
                        {{ $room->light_on ? 'On' : 'Off' }}
                    </span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 4h16v16H4V4z" />
                    </svg>
                    Shade:
                    <span class="{{ $room->shade_open ? 'text-green-400' : 'text-red-400' }}">
                        {{ $room->shade_open ? 'Open' : 'Closed' }}
                    </span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v18m0 0l-3-3m3 3l3-3" />
                    </svg>
                    Temp: <span class="text-sky-300">22°C</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 2C12 2 4 10 4 16a8 8 0 0016 0c0-6-8-14-8-14z" />
                    </svg>
                    Humidity: <span class="text-blue-300">45%</span>
                </li>
            </ul>

            {{-- Action buttons --}}
            <div class="mt-5 flex gap-2">
                <form method="POST" action="{{ route('floorplan.toggleLight', $room) }}" class="w-1/2">
                    @csrf
                    <button
                        class="w-full px-3 py-2 text-white rounded-md bg-green-600 hover:bg-green-700 transition">Toggle Light</button>
                </form>
                <form method="POST" action="{{ route('floorplan.toggleShade', $room) }}" class="w-1/2">
                    @csrf
                    <button
                        class="w-full px-3 py-2 text-white rounded-md bg-black hover:bg-gray-900 transition">Toggle Shade</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
