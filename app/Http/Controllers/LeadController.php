<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $lead_type = 1;
        $keys = Key::all();

        return view('dashboard.leads.lead', compact('lead_type', 'keys'));
    }

    public function lead2() {
        $lead_type = 2;
        $lead_sources = LeadSource::all();

        return view('dashboard.leads.lead', compact('lead_type', 'lead_sources'));
    }
}
