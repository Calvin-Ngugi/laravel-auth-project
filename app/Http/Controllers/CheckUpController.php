<?php

namespace App\Http\Controllers;

use App\Models\CheckUp;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = CheckUp::select('check_ups.*', 'patients.id_number as patient_idnumber')
            ->leftJoin('patients', 'check_ups.patient_id', '=', 'patients.id');

        // Check for sorting parameters
        $sortColumn = $request->input('sort_by', 'patient_id');
        $sortOrder = $request->input('sort_order', 'asc');

        if ($sortColumn == 'patient_id') {
            $query->orderBy('patient_id', $sortOrder);
        } elseif ($sortColumn == 'height') {
            $query->orderBy('height', $sortOrder);
        } elseif ($sortColumn == 'weight') {
            $query->orderBy('weight', $sortOrder);
        } elseif ($sortColumn == 'temperature') {
            $query->orderBy('temperature', $sortOrder);
        } elseif ($sortColumn == 'blood_pressure') {
            $query->orderBy('blood_pressure', $sortOrder);
        }

        // Handle search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('patients.id_number', 'like', '%' . $search . '%');
        }

        $checkups = $query->paginate(8);

        return view('checkups.checkups', compact('checkups', 'sortColumn', 'sortOrder'));
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
        // Create a new checkup record
        
        CheckUp::create($insertedData);

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

    public function liveSearch(Request $request)
    {
        $query = $request->input('query');
        $results = CheckUp::select('check_ups.*', 'patients.name', 'patients.id_number')
        ->leftJoin('patients', 'check_ups.patient_id', '=', 'patients.id')
        ->where('patients.id_number', 'like', '%' . $query . '%')
            ->get();

        return $results;
    }
}
