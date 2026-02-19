<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('number')->paginate(15);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|string|max:50|unique:rooms,number',
            'type' => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:1',
            'rent' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ]);
        Room::create($data);
        return redirect()->route('admin.rooms.index')->with('status', 'Room created');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'number' => 'required|string|max:50|unique:rooms,number,'.$room->id,
            'type' => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:1',
            'rent' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ]);
        $room->update($data);
        return redirect()->route('admin.rooms.index')->with('status', 'Room updated');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('status', 'Room deleted');
    }
}
