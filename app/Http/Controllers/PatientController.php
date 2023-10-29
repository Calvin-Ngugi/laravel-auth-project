<?php

namespace App\Http\Controllers;

use App\Models\CheckUp;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        // Check if a search term and column are provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Handle sorting
        $sortColumn = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        if (in_array($sortColumn, ['name', 'gender', 'dob', 'phone_number', 'id_number'])) {
            $query->orderBy($sortColumn, $sortOrder);
        } else {
            $sortColumn = 'id'; // Default sorting column
            $sortOrder = 'asc';  // Default sorting order
        }

        // Retrieve paginated patients
        $patients = $query->paginate(5);

        return view('patients.patients', compact('patients', 'sortColumn', 'sortOrder'));
    }

    public function create()
    {
        return view('patients.createPatient');
    }

    public function post(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'date' => 'required|date',
            'phone' => 'required',
            'idNumber' => 'required',
            'email' => 'nullable',
            'nok_name' => 'required',
            'nok_phone' => 'required',
            'nok_relation' => 'required'
        ]);

        $insertData = [
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'dob' => $validatedData['date'],
            'phone_number' => $validatedData['phone'],
            'id_number' => $validatedData['idNumber'],
            'email' => $validatedData['email'],
            'next_of_kin_name' => $validatedData['nok_name'],
            'next_of_kin_phone' => $validatedData['nok_phone'],
            'next_of_kin_relationship' => $validatedData['nok_relation'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Patient::create($insertData);

        return redirect()->route('patients.index');
    }

    public function show($id)
    {
        // Retrieve and display a single patient's details
        $patient = Patient::findOrFail($id);
        $checkUps = CheckUp::where('patient_id', $id)->get();

        return view('patients.patient', compact('patient', 'checkUps'));
    }

    public function edit($id)
    {
        // Retrieve and display a form for editing a patient's information
        $patient = Patient::findOrFail($id);
        return view('patients.editPatient', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        // Validate and update a patient's information in the database
        $patient = Patient::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'date' => 'required|date',
            'phone' => 'required',
            'idNumber' => 'required',
            'email' => 'nullable',
            'nok_name' => 'required',
            'nok_phone' => 'required',
            'nok_relation' => 'required'
        ]);

        $editedData = [
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'dob' => $validatedData['date'],
            'phone_number' => $validatedData['phone'],
            'id_number' => $validatedData['idNumber'],
            'email' => $validatedData['email'],
            'next_of_kin_name' => $validatedData['nok_name'],
            'next_of_kin_phone' => $validatedData['nok_phone'],
            'next_of_kin_relationship' => $validatedData['nok_relation'],
            'updated_at' => now(),
        ];

        // Use the update method to update the patient's data
        $patient->update($editedData);

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully');
    }

    public function destroy($id)
    {
        // Delete a patient from the database
    }

    public function checkUpHistory($id)
    {
        $patient = Patient::findOrFail($id);
        $checkUps = CheckUp::where('patient_id', $id)->get();

        return view('patients.check_up_history', compact('patient', 'checkUps'));
    }
}
