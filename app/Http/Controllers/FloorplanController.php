<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

public function index()
{
    $rooms = Room::all();
    return view('floorplan.index', compact('rooms'));
}

public function toggleLight(Room $room)
{
    $room->light_on = !$room->light_on;
    $room->save();
    return back();
}

public function toggleShade(Room $room)
{
    $room->shade_open = !$room->shade_open;
    $room->save();
    return back();
}
