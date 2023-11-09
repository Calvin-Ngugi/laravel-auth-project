<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends Controller
{
    public function index(Request $request)
    {
        $diagnoses = Diagnosis::paginate(8);

        return view('diagnosis.diagnoses', compact('diagnoses'));
    }

    public function create()
    {
        $medicines = Medicine::all();
        $patients = Patient::all();
        $tests = Service::whereNotIn('name', ['Maternity'])->get();
        return view('diagnosis.createDiagnosis', compact('tests', 'medicines', 'patients'));
    }

    public function post(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required',
            'symptoms' => 'required',
            'disease' => 'nullable',
            'test' => 'nullable',
            'test_results' => 'nullable',
            'treatments' => 'nullable',
        ]);

        $insertedData = [
            'patient_id' => $validatedData['patient_id'],
            'doctor_id' => Auth::user()->id,
            'symptoms' => $validatedData['symptoms'],
            'test' => json_encode($validatedData['test']),
            'test_results' => $validatedData['test_results'],
            'disease' => $validatedData['disease'],
            'treatments' => json_encode($validatedData['treatments']),
        ];

        Diagnosis::create($insertedData);

        return redirect()->route('medicine.index')->with('success', 'Diagnosis created');
    }
}
