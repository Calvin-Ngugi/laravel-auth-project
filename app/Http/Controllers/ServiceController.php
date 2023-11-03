<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{  
    public function index()
    {
        $services = Service::paginate(8);

        return view('services.services', compact('services'));
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
        //
    }

    
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
}
