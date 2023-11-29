<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Billing;
use App\Models\CheckUp;
use App\Models\Diagnosis;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query();

        // Handle sorting
        $sortColumn = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        $validSortColumns = ['patient_name', 'receptionist_name', 'finance_name', 'nurse_name', 'doctor_name', 'room_name', 'status'];

        if (in_array($sortColumn, $validSortColumns)) {
            // Modify the sorting logic based on your relationships
            $query->orderBy($sortColumn, $sortOrder);
        } else {
            $sortColumn = 'id'; // Default sorting column
            $sortOrder = 'asc';  // Default sorting order
        }

        // Retrieve paginated appointments with eager-loaded relationships
        $appointments = $query->with(['patient', 'receptionist', 'billing.finance', 'checkup.nurse', 'diagnosis.doctor', 'room'])->paginate(8);

        return view('appointments.appointments', compact('appointments', 'sortColumn', 'sortOrder'));
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

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        $medicines = Medicine::all();
        $services = Service::all();

        return view('appointments.appointment', compact('appointment', 'services', 'medicines'));
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
        $prescriptions = Prescription::all();

        return view('appointments.appointDiagnosis', compact('diagnosis', 'patient', 'appointment', 'medicines', 'tests', 'previousDiagnosis', 'prescriptions'));
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
            $quantity = $request->quantity;

            if ($appointment->diagnosis_id) {
                // Patient already has a checkup, update the existing checkup
                $diagnosis = Diagnosis::findOrFail($appointment->diagnosis_id);
                $diagnosis->update($validatedData);
                $diagnosis->prescriptions()->update(['is_valid' => 0]);

                if (isset($request->treatments) && !empty($request->treatments)) {
                    $medicines = $request->treatments;
                    $patient_id = $validatedData['patient_id'];
                    $appointment_id = $appointment['id'];
                    $prescriptions = $diagnosis->prescriptions;

                    foreach ($medicines as $index => $medicine_id) {
                        // Check if there is an existing prescription for the medicine in the diagnosis
                        $existingPrescription = $prescriptions->where('medicine_id', $medicine_id)->first();

                        if ($existingPrescription) {
                            // Update the existing prescription
                            $existingPrescription->update([
                                'is_valid' => 1,
                                'quantity' => $quantity[$index],
                            ]);
                        } else {
                            // Create a new prescription
                            Prescription::create([
                                'patient_id' => $patient_id,
                                'appointment_id' => $appointment_id,
                                'medicine_id' => $medicine_id,
                                'quantity' => $quantity[$index],
                                'diagnosis_id' => $diagnosis->id,
                                'is_valid' => 1
                            ]);
                        }
                    }
                }
            } else {
                // Create a new checkup
                $newData = array_merge($validatedData, [
                    'doctor_id' => Auth::user()->id,
                ]);
                $diagnosis = Diagnosis::create($newData);

                if (isset($request->treatments) && !empty($request->treatments)) {
                    $medicines = $request->treatments;
                    $patient_id = $validatedData['patient_id'];
                    $appointment_id = $appointment['id'];

                    foreach ($medicines as $index => $medicine_id) {
                        $medicine_id = $medicine_id;
                        Prescription::create([
                            'patient_id' => $patient_id,
                            'appointment_id' => $appointment_id,
                            'medicine_id' => $medicine_id,
                            'quantity' => $quantity[$index],
                            'diagnosis_id' => $diagnosis->id,
                            'is_valid' => 1,
                        ]);
                    }
                }
                // Update the appointment table with the new checkup ID and status
                $appointment->update([
                    'diagnosis_id' => $diagnosis->id,
                    'status' => 'ongoing',
                ]);
            }

            // Commit the transaction
            DB::commit();

            $appointment = Appointment::findOrFail($appointment_id);
            $this->updateMedicineCostInBilling($appointment);
            $this->calculateServicesCostInDiagnosis($appointment);

            // Return success response or redirect
            return redirect()->back()->with('success', 'Diagnosis created or updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Enter quantity to proceed');
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
        $patient = Patient::findOrFail($patient_id);
        $appointment = Appointment::with('billing')->findOrFail($id);

        return view('appointments.appointBilling', compact('patient', 'appointment'));
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

    public function payTotal($appointmentId)
    {
        try {
            // Fetch the appointment
            $appointment = Appointment::findOrFail($appointmentId);

            // Fetch the associated billing
            $billing = $appointment->billing;

            if ($billing && $billing->status === 'unpaid') {
                // Calculate the total by adding services_cost and medicine_cost
                $total = $billing->services_cost + $billing->medicine_cost + 2000;

                // Update the total field
                // dd($total);
                $billing->update([
                    'total' => $total,
                    'status' => 'paid',
                    'finance_id' => Auth::user()->id
                ]);

                // Redirect back with success message
                return redirect()->back()->with('success', 'Paid successfully');
            }

            // Redirect back with error message if billing doesn't exist or has already been paid
            return redirect()->back()->with('error', 'Bill not found or already paid');
        } catch (\Exception $e) {
            // Handle exceptions, log errors, or redirect with an error message
            return redirect()->back()->with('error', 'An error occurred during checkout. Please try again.');
        }
    }

    public function checkout($appointmentId)
    {
        // Find the appointment
        $appointment = Appointment::findOrFail($appointmentId);

        // Check if the appointment has a room assigned
        if (!$appointment->room_id) {
            return redirect()->back()->with('error', 'No room assigned. Please assign a room first.');
        }

        // Check if the billing is paid
        if ($appointment->billing->status != 'paid') {
            return redirect()->back()->with('error', 'Pay up to checkout');
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

        // Decrement the no_in_inventory for each medicine associated with the prescriptions
        foreach ($appointment->diagnosis->prescriptions as $prescription) {
            $medicine = $prescription->medicine;

            // Assuming you have a 'no_in_inventory' column in your medicines table
            if ($medicine->no_in_inventory > 0) {
                $medicine->decrement('no_in_inventory');
            }
        }

        return redirect()->route('appointment.index')->with('success', 'Patient removed from the room successfully.');
    }

    private function updateMedicineCostInBilling($appointment)
    {
        // Calculate the total medicine cost and update the billing record
        $totalMedicineCost = 0;
        // Loop through associated prescriptions
        foreach ($appointment->diagnosis->prescriptions as $prescription) {
            // Calculate the cost for the current prescription and add to the total
            if ($prescription->is_valid) {
                $medicineCost = $prescription->quantity * $prescription->medicine->unit_cost;
                $totalMedicineCost += $medicineCost;
            }
        }

        // Update the billing record with the total medicine cost
        $billing = $appointment->billing;
        $billing->update([
            'medicine_cost' => $totalMedicineCost,
            'status' => 'unpaid'
        ]);
    }

    private function calculateServicesCostInDiagnosis($appointment)
    {
        // Decode the JSON string in the 'tests' field
        $tests = json_decode($appointment->diagnosis->tests);
        $billing = $appointment->billing;
        // Initialize the total services cost
        $totalServicesCost = 0;

        // Check if 'tests' is not empty and is an array
        if (!empty($tests) && is_array($tests)) {
            // Loop through the tests array and sum up the 'services_cost'
            foreach ($tests as $test) {
                $service = Service::findOrFail($test);
                // dd($service);
                if (isset($service['unit_cost'])) {
                    $totalServicesCost += $service['unit_cost'];
                }
            }
        }

        // Update the diagnosis record with the total services cost
        $billing->update([
            'services_cost' => $totalServicesCost,
        ]);
    }
}
