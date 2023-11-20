<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Billing;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $billings = Billing::all();

        return view('billings.showBills', compact('billings'));
    }

    public function calculateTotal($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Access related data
        $medicinesCost = $appointment->diagnosis->medicines->sum('unit_cost');
        $servicesCost = $appointment->diagnosis->services->sum('unit_cost');

        // Calculate total
        $total = $medicinesCost + $servicesCost + $appointment->billing->consultation_fee;

        // Update billing record
        $appointment->billing->update([
            'total' => $total,
        ]);

        return redirect()->back()->with('success', 'Billing total calculated and updated.');
    }
}
