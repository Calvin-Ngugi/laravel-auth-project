<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{  
    public function index(Request $request)
    {
        $query = Service::query();

        // Check if a search term and column are provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Handle sorting
        $sortColumn = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        if (in_array($sortColumn, ['name', 'unit_cost', 'status'])) {
            $query->orderBy($sortColumn, $sortOrder);
        } else {
            $sortColumn = 'id'; // Default sorting column
            $sortOrder = 'asc';  // Default sorting order
        }

        // Retrieve paginated services
        $services = $query->paginate(8);

        return view('services.services', compact('services', 'sortColumn', 'sortOrder'));
    }

    public function create()
    {
        return view('services.createService');
    }

    
    public function post(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'unit_cost' => 'required',
            'status' => 'required'
        ]);

        $insertedData = [
            'name' => $validatedData['name'],
            'unit_cost' => $validatedData['unit_cost'],
            'status' => $validatedData['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Service::create($insertedData);

        return redirect()->route('services.index')->with('success', 'Service created');
    }

    
    public function show($id)
    {
        $service = Service::findOrFail($id);
        return view('services.service', compact('service'));
    }

    
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.editService', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required',
            'unit_cost' => 'required',
            'status' => 'required'
        ]);

        $insertedData = [
            'name' => $validatedData['name'],
            'unit_cost' => $validatedData['unit_cost'],
            'status' => $validatedData['status'],
            'updated_at' => now(),
        ];

        $service->update($insertedData);

        return redirect()->route('services.index')->with('success', 'Service updated');
    }

    public function liveSearch(Request $request)
    {
        $query = $request->input('query');
        $results = Service::where('name', 'like', '%' . $query . '%')->get();

        return $results;
    }
}
