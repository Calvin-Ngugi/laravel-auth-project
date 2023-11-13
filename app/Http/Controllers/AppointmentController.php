<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CheckUp;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $patient = Patient::findorFail($patient_id);
        $appointment = Appointment::find($id);

        return view('appointments.appointCheckup', compact('checkups', 'patient', 'appointment'));
    }

    public function postCheckup(Request $request, $appointmentId)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create the checkup table
            $validatedData = $request->validate([
                'patient_id' => 'required',
                'height' => 'required',
                'weight' => 'required',
                'temperature' => 'required',
                'blood_pressure' => 'required',
                'blood_sugar' => 'required',
                'heart_rate' => 'required',
            ]);
            
            $insertedData = [
                'patient_id' => $validatedData['patient_id'],
                'height' => $validatedData['height'],
                'weight' => $validatedData['weight'],
                'temperature' => $validatedData['temperature'],
                'blood_pressure' => $validatedData['blood_pressure'],
                'blood_sugar' => $validatedData['blood_sugar'],
                'heart_rate' => $validatedData['heart_rate'],
                'nurse_id' => Auth::user()->id,
            ];
            
            
            $checkup = CheckUp::create($insertedData);
            $checkupId = $checkup->id;
            // Update the appointment table with the checkup ID and status
            $appointment = Appointment::findOrFail($appointmentId);
            $appointment->update([
                'checkup_id' => $checkupId,
                'status' => 'ongoing',
            ]);
            // dd($insertedData);
            // Commit the transaction
            DB::commit();

            // Return success response or redirect
            return redirect()->back()->with('success', 'Checkup started successfully');
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Return error response or redirect
            return redirect()->back()->with('error', 'Error updating checkup. Please try again.');
        }
    }

    public function diagnosis(Request $request)
    {
        $checkups = CheckUp::all();

        return view('appointments.appointCheckup', compact('patients'));
    }

}
