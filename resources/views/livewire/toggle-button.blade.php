<div>
    <button
        wire:click="toggle"
        class="{{ $zone->status ? 'bg-green-600' : 'bg-gray-600' }} px-3 py-1 rounded text-white"
    >
        {{ $zone->status ? 'ON' : 'OFF' }}
    </button>
</div>
