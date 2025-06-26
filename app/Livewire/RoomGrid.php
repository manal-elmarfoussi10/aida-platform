<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;

class RoomGrid extends Component
{
    public function render()
    {
        return view('livewire.room-grid', [
            'rooms' => \App\Models\Room::all()
        ]);
    }
}
