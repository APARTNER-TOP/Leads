<?php

namespace App\Http\Controllers;

use App\Models\LeadSource;
use Illuminate\Http\Request;
use App\Models\Check;

class LeadSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Check::isAdmin()) {
            return redirect('/dashboard');
        }

        $lead_sources = LeadSource::all();

        return view('dashboard.lead_source.index', compact('lead_sources'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Check::isAdmin()) {
            return redirect('/dashboard');
        }

        return view('dashboard.lead_source.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Check::isAdmin()) {
            return redirect('/dashboard');
        }

        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email'
        ]);

        if(LeadSource::create($request->all())) {
            return redirect('/dashboard/lead_source')->with('success', 'Lead source successfully created!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Check::isAdmin()) {
            return redirect('/dashboard');
        }

        $key = LeadSource::find($id);

        return view('dashboard.lead_source.edit', compact('key'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Check::isAdmin()) {
            return redirect('/dashboard');
        }

        $key = LeadSource::find($id);

        // dd($key);
        $key->fill($request->all());
        if($key->save()) {
            return redirect('/dashboard/lead_source')->with('success', 'lead source update');
        }

        return back()->with('erorr','error not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Check::isAdmin()) {
            return redirect('/dashboard');
        }

        if(LeadSource::find($id)->delete()) {
            return redirect('/dashboard/lead_source')->with('success','successfully deleted');
        }

        return back()->with('erorr','error not found');
    }
}
