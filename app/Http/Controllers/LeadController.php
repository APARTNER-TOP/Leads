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
        $keys = Key::all();
        $job = false;
        $form_js = true;

        return view('dashboard.leads.lead1', compact('keys', 'job', 'form_js'));
    }

    public function lead2(Request $request) {
        $lead_sources = LeadSource::all();
        $job = false;
        $form_js = true;

        return view('dashboard.leads.lead2', compact( 'lead_sources', 'job', 'form_js'));
    }
}
