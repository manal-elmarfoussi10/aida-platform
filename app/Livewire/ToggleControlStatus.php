<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Control;

class ToggleControlStatus extends Component
{
    public Control $control;

    public function toggle()
    {
        $this->control->current_status = !$this->control->current_status;
        $this->control->save();
    }

    public function render()
    {
        return view('livewire.toggle-control-status');
    }
}
