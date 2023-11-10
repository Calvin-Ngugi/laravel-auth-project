<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CheckUp;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::paginate(8);

        return view('appointments.appointments', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();

        return view('appointments.createAppointment', compact('patients'));
    }

    public function post(Request $request){
        $validatedData = $request->validate([
            'patient_id' => 'required',
        ]);

        $insertedData = [
            'patient_id' => $validatedData['patient_id'],
            'receptionist_id' => Auth::user()->id,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ];

        Appointment::create($insertedData);

        return redirect()->route('appointment.index')->with('success', 'Appointment created');
    }

    public function checkup($patient_id, $id)
    {
        $checkups = CheckUp::all();

        return view('appointments.appointCheckup', compact('checkups'));
    }

    public function diagnosis(Request $request)
    {
        $checkups = CheckUp::all();

        return view('appointments.appointCheckup', compact('patients'));
    }
}
