<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    //
    public function index()
    {
        $listings = Listing::all();
        return view('listings', compact('listings'));
    }
}
