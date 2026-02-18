<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::paginate(15);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:rooms,code|max:20',
            'name' => 'required|string|max:255',
            'building' => 'required|string|max:100',
            'floor' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:lecture,laboratory,computer_lab,workshop',
            'facilities' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:rooms,code,' . $room->id,
            'name' => 'required|string|max:255',
            'building' => 'required|string|max:100',
            'floor' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|in:lecture,laboratory,computer_lab,workshop',
            'facilities' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
