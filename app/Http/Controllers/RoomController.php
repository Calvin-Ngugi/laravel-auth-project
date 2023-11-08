<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::paginate(8);

        return view('rooms.rooms', compact('rooms'));
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['super-admin'])->get();
        return view('rooms.createRoom', compact('roles'));
    }

    public function post(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'status' => 'required',
            'capacity' => 'required',
        ]);

        $insertedData = [
            'name' => $validatedData['name'],
            'role_id' => $validatedData['role_id'],
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
        $roles = Role::whereNotIn('name', ['super-admin'])->get();
        
        return view('rooms.editRoom', compact('room', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'capacity' => 'required',
            'status' => 'required',
        ]);

        $insertedData = [
            'name' => $validatedData['name'],
            'role_id' => $validatedData['role_id'],
            'capacity' => $validatedData['capacity'],
            'status' => $validatedData['status'],
            'updated_at' => now(),
        ];

        $room->update($insertedData);

        return redirect()->route('rooms.index')->with('success', 'Room updated');
    }
}
