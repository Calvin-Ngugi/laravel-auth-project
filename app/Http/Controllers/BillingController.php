<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $billings = Billing::paginate(10);

        return view('billings.showBills', compact('billings'));
    }
}
