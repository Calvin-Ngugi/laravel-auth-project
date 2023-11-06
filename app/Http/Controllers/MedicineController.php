<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::paginate(8);
        
        return view('medicine.medicines', compact('medicines'));
    }

    public function create()
    {
        return view('medicine.createMedicine');
    }

    public function post(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'unit_cost' => 'required',
            'no_in_inventory' => 'required'
        ]);

        $insertedData = [
            'name' => $validatedData['name'],
            'unit_cost' => $validatedData['unit_cost'],
            'no_in_inventory' => $validatedData['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Medicine::create($insertedData);

        return redirect()->route('medicine.index')->with('success', 'Medicine updated');
    }

    public function show($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('medicine.med', compact('medicine'));
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('medicine.editMedicine', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'unit_cost' => 'required',
            'no_in_inventory' => 'required'
        ]);

        $insertedData = [
            'name' => $validatedData['name'],
            'unit_cost' => $validatedData['unit_cost'],
            'no_in_inventory' => $validatedData['status'],
            'updated_at' => now(),
        ];

        $medicine->update($insertedData);

        return redirect()->route('medicine.index')->with('success', 'Medicine updated');
    }
}
