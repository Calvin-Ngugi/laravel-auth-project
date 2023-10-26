<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        // Retrieve a list of patients from the database
        $patients = Patient::all();
        $patients = Patient::paginate(5);

        return view('patients.patients', compact('patients'));
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
        return view('patients.patient', compact('patient'));
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
}
