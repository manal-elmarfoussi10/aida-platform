<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ZoneV2;

class ToggleButton extends Component
{
    public ZoneV2 $zone;

    public function toggle()
    {
        $this->zone->status = !$this->zone->status;
        $this->zone->save();
    }
    public function render()
    {
        return view('livewire.toggle-button');
    }
}
