<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('floorplan.index', compact('rooms'));
    }

    public function create()
    {
        return view('floorplan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Room::create([
            'name' => $request->name,
        ]);

        return redirect()->route('floorplan')->with('success', 'Room added!');
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
}
