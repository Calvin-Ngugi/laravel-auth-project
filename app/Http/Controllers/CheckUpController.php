<?php

namespace App\Http\Controllers;

use App\Models\CheckUp;
use App\Models\Patient;
use Illuminate\Http\Request;

class CheckUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkups = CheckUp::all();
        $checkups = CheckUp::paginate(5);
        return view('checkups.checkups', compact('checkups'));
    }

    public function create()
    {
        $patients = Patient::all();

        return view('checkups.createCheckup', compact('patients'));
    }

    public function post(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'temperature' => 'required',
            'blood_pressure' => 'required',
            'blood_sugar' => 'required',
            'heart_rate' => 'required',
        ]);

        // Create a new checkup record
        CheckUp::create($validatedData);

        return redirect()->route('checkups.index')->with('success', 'Checkup added successfully');
    }

    public function show($id)
    {
        $checkup = CheckUp::findorFail($id);

        return view('checkups.checkup', compact('checkup'));
    }

    public function edit($id)
    {
        $checkup = CheckUp::findorFail($id);

        return view('checkups.editCheckup', compact('checkup'));
    }

    public function update(Request $request, $id)
    {
        $checkup = CheckUp::findorFail($id);
        $validatedData = $request->validate([
            'height' => 'required',
            'weight' => 'required',
            'temperature' => 'required',
            'blood_pressure' => 'required',
            'blood_sugar' => 'required',
            'heart_rate' => 'required',
        ]);
        
        $checkup->update($validatedData);

        return redirect()->route('checkups.index')->with('success', 'Checkup updated successfully');
    }

    public function destroy($id)
    {
        //
    }
}
