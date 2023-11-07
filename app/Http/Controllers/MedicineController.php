<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();

        // Check if a search term and column are provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('id_number', 'like', '%' . $search . '%');
        }

        // Handle sorting
        $sortColumn = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        if (in_array($sortColumn, ['name', 'unit_cost', 'no_in_inventory', 'type'])) {
            $query->orderBy($sortColumn, $sortOrder);
        } else {
            $sortColumn = 'id'; // Default sorting column
            $sortOrder = 'asc';  // Default sorting order
        }

        // Retrieve paginated medicines
        $medicines = $query->paginate(8);

        return view('medicine.medicines', compact('medicines', 'sortColumn', 'sortOrder'));
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
            'no_in_inventory' => 'required',
            'type' => 'required',
        ]);

        $insertedData = [
            'name' => $validatedData['name'],
            'unit_cost' => $validatedData['unit_cost'],
            'no_in_inventory' => $validatedData['no_in_inventory'],
            'type' => $validatedData['type'],
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
            'no_in_inventory' => 'required',
            'type' => 'required',
        ]);

        $insertedData = [
            'name' => $validatedData['name'],
            'unit_cost' => $validatedData['unit_cost'],
            'no_in_inventory' => $validatedData['no_in_inventory'],
            'type' => $validatedData['type'],
            'updated_at' => now(),
        ];

        $medicine->update($insertedData);

        return redirect()->route('medicine.index')->with('success', 'Medicine updated');
    }

    public function liveSearch(Request $request)
    {
        $query = $request->input('query');
        $results = Medicine::where('name', 'like', '%' . $query . '%')->get();

        return $results;
    }
}
