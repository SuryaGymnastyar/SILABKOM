<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'facilities' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'condition' => 'nullable|string|in:Baik,Perbaikan',
        ]);

        Room::create($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Lab berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'facilities' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'condition' => 'nullable|string|in:Baik,Perbaikan',
        ]);

        $room->update($request->all());

        return redirect()->route('admin.rooms.index')->with('success', 'Lab berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Lab berhasil dihapus.');
    }
}