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

        return view('patients.patients', compact('patients'));
    }

    public function create()
    {
        return view('patients.createPatient');
    }

    public function post(Request $request)
    {
        // Validate and store a new patient in the database
    }

    public function show($id)
    {
        // Retrieve and display a single patient's details
    }

    public function edit($id)
    {
        // Retrieve and display a form for editing a patient's information
    }

    public function update(Request $request, $id)
    {
        // Validate and update a patient's information in the database
    }

    public function destroy($id)
    {
        // Delete a patient from the database
    }
}
