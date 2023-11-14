<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CheckUp;
use App\Models\Diagnosis;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Service;
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

        $previousCheckup = $appointment->checkup;

        return view('appointments.appointCheckup', compact('checkups', 'patient','appointment', 'previousCheckup'));
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

    public function diagnosis($patient_id, $id)
    {
        $diagnosis = Diagnosis::all();
        $patient = Patient::findorFail($patient_id);
        $appointment = Appointment::find($id);
        $tests = Service::all();
        $medicines = Medicine::all();

        return view('appointments.appointDiagnosis', compact('diagnosis', 'patient', 'appointment', 'medicines', 'tests'));
    }

    public function postDiagnosis(Request $request, $appointmentId)
    {
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'patient_id' => 'required',
                'symptoms' => 'required',
                'disease' => 'nullable',
                'test' => 'nullable',
                'test_results' => 'nullable',
                'treatments' => 'nullable',
            ]);
            
            // Create the diagnosis record
            $insertedData = [
                'patient_id' => $validatedData['patient_id'],
                'doctor_id' => Auth::user()->id,
                'symptoms' => $validatedData['symptoms'],
                'test' => json_encode($validatedData['test']),
                'test_results' => $validatedData['test_results'],
                'disease' => $validatedData['disease'],
                'treatments' => json_encode($validatedData['treatments']),
            ];
            
            $diagnosis = Diagnosis::create($insertedData);
            $diagnosisId = $diagnosis->id;
            
            // Update the appointment table with the diagnosis ID and status
            $appointment = Appointment::findOrFail($appointmentId);
            $appointment->update([
                'diagnosis_id' => $diagnosisId,
                'status' => 'ongoing',
            ]);

            // Commit the transaction
            DB::commit();

            // Return success response or redirect
            return redirect()->route('appointment.index')->with('success', 'Diagnosis created');
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Return error response or redirect
            return redirect()->back()->with('error', 'Error creating diagnosis. Please try again.');
        }
    }

}
