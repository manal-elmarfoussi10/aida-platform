<?php

namespace App\Livewire;

use Livewire\Component;

class ToggleDeviceStatus extends Component
{
    public Device $device;

    public function toggle()
    {
        $this->device->current_status = !$this->device->current_status;
        $this->device->save();
    }
    public function render()
    {
        return view('livewire.toggle-device-status');
    }
}
