<div class="flex items-center justify-center">
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" wire:click="toggle" {{ $control->current_status ? 'checked' : '' }} class="sr-only peer">
        <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-green-500 rounded-full peer peer-checked:bg-green-500 transition-all duration-300"></div>
        <span class="ml-3 text-sm font-medium text-white">
            {{ $control->current_status ? 'ON' : 'OFF' }}
        </span>
    </label>
</div>
