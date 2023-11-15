<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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

    public function assignRoom(Request $request, $appointmentId)
    {
        // Find the appointment
        $appointment = Appointment::findOrFail($appointmentId);

        // Check if the appointment already has a room assigned
        if ($appointment->room_id) {
            return redirect()->route('appointments.index')->with('error', 'Appointment already has a room assigned.');
        }

        // Find an available room based on your criteria (you need to implement this logic)
        $room = $this->findAvailableRoom();

        if (!$room) {
            return redirect()->route('appointments.index')->with('error', 'No available rooms. Please try again later.');
        }

        // Update the appointment with the selected room
        $appointment->update([
            'room_id' => $room->id,
            // You might want to update other fields like status here
        ]);

        $room->update(['status' => 'occupied']);

        return redirect()->route('appointments.index')->with('success', 'Room assigned successfully.');
    }

    private function findAvailableRoom()
    {
        // Find a room with the nurse role and status 'available'
        $room = Room::where('role_id', Role::where('name', 'nurse')->first()->id)
            ->where('status', 'available')
            ->first();

        return $room;
    }
}
