<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Billing;
use App\Models\CheckUp;
use App\Models\Diagnosis;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

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

    public function post(Request $request)
    {
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

        return view('appointments.appointCheckup', compact('checkups', 'patient', 'appointment', 'previousCheckup'));
    }

    public function postCheckup(Request $request, $appointmentId)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'patient_id' => 'required',
                'height' => 'required',
                'weight' => 'required',
                'temperature' => 'required',
                'blood_pressure' => 'required',
                'blood_sugar' => 'required',
                'heart_rate' => 'required',
            ]);

            // Check if the patient already has a checkup
            $appointment = Appointment::findOrFail($appointmentId);

            if ($appointment->checkup_id) {
                // Patient already has a checkup, update the existing checkup
                $checkup = CheckUp::findOrFail($appointment->checkup_id);
                $checkup->update($validatedData);
            } else {
                // Create a new checkup
                $insertedData = array_merge($validatedData, [
                    'nurse_id' => Auth::user()->id,
                ]);
                $checkup = CheckUp::create($insertedData);

                // Update the appointment table with the new checkup ID and status
                $appointment->update([
                    'checkup_id' => $checkup->id,
                    'status' => 'ongoing',
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response or redirect
            return redirect()->back()->with('success', 'Checkup updated successfully');
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Return error response or redirect
            return redirect()->back()->with('error', 'Error updating checkup. Please try again.');
        }
    }

    public function proceedToDiagnosis($appointmentId)
    {
        // Find the appointment
        $appointment = Appointment::findOrFail($appointmentId);

        // Check if the appointment has a room assigned
        if (!$appointment->room_id) {
            return redirect()->back()->with('error', 'No room assigned. Please assign a room first.');
        }

        // Find the current room
        $currentRoom = Room::findOrFail($appointment->room_id);

        // Find an available room with a doctor role
        $doctorRoom = Room::where('role_id', Role::where('name', 'doctor')->first()->id)
            ->where('status', 'available')
            ->first();

        // Check if a doctor room is available
        if (!$doctorRoom) {
            return redirect()->back()->with('error', 'No doctor room available. Please try again later.');
        }

        // Transfer quantity from the current room to the doctor room
        $transferQuantity = min($currentRoom->quantity, $doctorRoom->capacity - $doctorRoom->quantity);
        $currentRoom->update(['quantity' => $currentRoom->quantity - $transferQuantity]);
        $doctorRoom->update(['quantity' => $doctorRoom->quantity + $transferQuantity]);

        $currentRoom->update(['status' => 'available']);

        // Update the appointment with the doctor room
        $appointment->update([
            'room_id' => $doctorRoom->id,
        ]);

        if ($doctorRoom['quantity'] == $doctorRoom['capacity']) {
            $doctorRoom->update(['status' => 'occupied']);
        }


        return redirect()->route('appointment.diagnosis', ['patient_id' => $appointment['patient_id'], 'id' => $appointment['id']])
            ->with('success', 'Diagnosis Room assigned successfully.');
    }

    public function diagnosis($patient_id, $id)
    {
        $diagnosis = Diagnosis::all();
        $patient = Patient::findorFail($patient_id);
        $appointment = Appointment::find($id);
        $tests = Service::all();
        $medicines = Medicine::all();
        $previousDiagnosis = $appointment->diagnosis;

        return view('appointments.appointDiagnosis', compact('diagnosis', 'patient', 'appointment', 'medicines', 'tests', 'previousDiagnosis'));
    }

    public function postDiagnosis(Request $request, $appointmentId)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Validate the request data
            $insertedData = $request->validate([
                'patient_id' => 'required',
                'symptoms' => 'required',
                'disease' => 'nullable',
                'tests' => 'nullable',
                'test_results' => 'nullable',
                'treatments' => 'nullable',
            ]);

            $validatedData = [
                'patient_id' => $insertedData['patient_id'],
                'symptoms' => $insertedData['symptoms'],
                'disease' => $insertedData['disease'],
                'tests' => json_encode($insertedData['tests']),
                'test_results' => $insertedData['test_results'],
                'treatments' => json_encode($insertedData['treatments']),
            ];

            $appointment = Appointment::findOrFail($appointmentId);

            if ($appointment->diagnosis_id) {
                // Patient already has a checkup, update the existing checkup
                $diagnosis = Diagnosis::findOrFail($appointment->diagnosis_id);
                $diagnosis->update($validatedData);
            } else {
                // Create a new checkup
                $newData = array_merge($validatedData, [
                    'doctor_id' => Auth::user()->id,
                ]);
                $diagnosis = Diagnosis::create($newData);

                // Update the appointment table with the new checkup ID and status
                $appointment->update([
                    'diagnosis_id' => $diagnosis->id,
                    'status' => 'ongoing',
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return success response or redirect
            return redirect()->back()->with('success', 'Diagnosis created or updated successfully');
        } catch (\Exception $e) {
            // Something went wrong, rollback the transaction
            DB::rollback();

            // Return error response or redirect
            return redirect()->back()->with('error', 'Error creating or updating diagnosis. Please try again.');
        }
    }

    public function proceedToBilling($appointmentId)
    {
        // Find the appointment
        $appointment = Appointment::findOrFail($appointmentId);

        // Check if the appointment has a room assigned
        if (!$appointment->room_id) {
            return redirect()->back()->with('error', 'No room assigned. Please assign a room first.');
        }

        // Find the current room
        $currentRoom = Room::findOrFail($appointment->room_id);

        // Find an available room with a finance role
        $financeRoom = Room::where('role_id', Role::where('name', 'finance')->first()->id)
            ->where('status', 'available')
            ->first();

        // Check if a finance room is available
        if (!$financeRoom) {
            return redirect()->back()->with('error', 'Please try again later.');
        }

        // Transfer quantity from the current room to the finance room
        $transferQuantity = min($currentRoom->quantity, $financeRoom->capacity - $financeRoom->quantity);
        $currentRoom->update(['quantity' => $currentRoom->quantity - $transferQuantity]);
        $financeRoom->update(['quantity' => $financeRoom->quantity + $transferQuantity]);

        $currentRoom->update(['status' => 'available']);

        // Update the appointment with the finance room
        $appointment->update([
            'room_id' => $financeRoom->id,
        ]);

        if ($financeRoom['quantity'] == $financeRoom['capacity']) {
            $financeRoom->update(['status' => 'occupied']);
        }

        return redirect()->route('appointment.billing', ['patient_id' => $appointment['patient_id'], 'id' => $appointment['id']])->with('success', 'Accounts Room assigned successfully.');
    }

    public function billing($patient_id, $id)
    {
        $billings = Billing::all();
        $patient = Patient::findorFail($patient_id);
        $appointment = Appointment::find($id);

        return view('appointments.appointBilling', compact('billings', 'patient', 'appointment'));
    }

    public function payCheckup($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if ($appointment->billing_id) {
            return redirect()->route('appointments.index')->with('error', 'Checkup already paid.');
        }

        // Create a new billing record
        $billing = Billing::create([
            'appointment_id' => $appointment->id,
            'consultation_fee' => 'paid', // Adjust this based on your enum or string values
            'status' => 'unpaid', // Adjust this based on your enum or string values
            'finance_id' => Auth::user()->id,
        ]);

        // Update the appointment with the billing ID
        $appointment->update([
            'billing_id' => $billing->id,
        ]);

        return redirect()->route('appointment.index')->with('success', 'Checkup paid successfully.');
    }


    public function checkout($appointmentId)
    {
        // Find the appointment
        $appointment = Appointment::findOrFail($appointmentId);

        // Check if the appointment has a room assigned
        if (!$appointment->room_id) {
            return redirect()->back()->with('error', 'No room assigned. Please assign a room first.');
        }

        // Find the current room
        $currentRoom = Room::findOrFail($appointment->room_id);

        if ($currentRoom->role_id == Role::where('name', 'finance')->first()->id) {
            $currentRoom->update(['status' => 'available']);
        }

        if ($currentRoom->quantity > 0) {
            $currentRoom->update(['quantity' => $currentRoom->quantity - 1]);
        }

        // Update the appointment with no room assigned
        $appointment->update([
            'room_id' => null,
            'status' => 'completed'
        ]);

        return redirect()->route('appointment.index')->with('success', 'Patient removed from the room successfully.');
    }
}
