<div class="flex items-center space-x-2">
    <button wire:click="toggle" class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors duration-300 focus:outline-none {{ $device->current_status ? 'bg-green-500' : 'bg-gray-400' }}">
        <span class="inline-block w-4 h-4 transform bg-white rounded-full transition-transform duration-300 {{ $device->current_status ? 'translate-x-6' : 'translate-x-1' }}"></span>
    </button>
    <span class="text-sm font-medium {{ $device->current_status ? 'text-green-400' : 'text-gray-400' }}">
        {{ $device->current_status ? 'ON' : 'OFF' }}
    </span>
</div>
