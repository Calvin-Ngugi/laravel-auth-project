<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::paginate(8);

        return view('rooms.rooms', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.createRoom');
    }

    public function post(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'role_assigned' => 'required',
            'status' => 'required',
            'capacity' => 'required',
        ]);

        $insertedData = [
            'name' => $validatedData['name'],
            'role_assigned' => $validatedData['role_assigned'],
            'status' => $validatedData['status'],
            'capacity' => $validatedData['capacity'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Room::create($insertedData);

        return redirect()->route('rooms.index')->with('success', 'Room created');
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.room', compact('room'));
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.editRoom', compact('room'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'role_assigned' => 'required',
            'no_in_inventory' => 'required',
            'type' => 'required',
        ]);

        $insertedData = [
            'name' => $validatedData['name'],
            'role_assigned' => $validatedData['role_assigned'],
            'no_in_inventory' => $validatedData['no_in_inventory'],
            'type' => $validatedData['type'],
            'updated_at' => now(),
        ];

        $room->update($insertedData);

        return redirect()->route('rooms.index')->with('success', 'Room updated');
    }
}
