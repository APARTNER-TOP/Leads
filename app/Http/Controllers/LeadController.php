<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Key;
use App\Models\LeadSource;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // index.php
    }

    public function lead1() {
        $keys = Key::all();

        return view('dashboard.leads.lead1', compact('keys'));
    }

    public function lead2(Request $request) {

        // dd($request);

        // $user = User::find(2);
        $lead_sources = LeadSource::all();

        return view('dashboard.leads.lead2', compact( 'lead_sources'));
    }
}
