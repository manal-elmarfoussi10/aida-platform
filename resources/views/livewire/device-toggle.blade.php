<div>
    <button wire:click="toggle" class="flex items-center">
        @if ($device->current_status)
            <span class="bg-green-600 text-xs px-3 py-1 rounded-full">ON</span>
        @else
            <span class="bg-gray-600 text-xs px-3 py-1 rounded-full">OFF</span>
        @endif
    </button>
</div>
