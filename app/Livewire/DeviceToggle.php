<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Device;

class DeviceToggle extends Component
{
    public Device $device;

    public function toggle()
    {
        $this->device->current_status = !$this->device->current_status;
        $this->device->save();
    }

    public function render()
    {
        return view('livewire.device-toggle');
    }
}
