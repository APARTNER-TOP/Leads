<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;
use App\Models\Check;

class keyController extends Controller
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

        $keys = Key::all();

        return view('dashboard.keys.index', compact('keys'));
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

        return view('dashboard.keys.create');
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
            'key'=>'required'
        ]);

        if(Key::create($request->all())) {
            return redirect('/dashboard/keys')->with('success', 'Key successfully created!');
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

        $key = Key::find($id);

        return view('dashboard.keys.edit', compact('key'));
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

        $key = Key::find($id);
        $key->fill($request->all());
        if($key->save()) {
            return redirect('/dashboard/keys')->with('success', 'key update');
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

        if(Key::find($id)->delete()) {
            return redirect('/dashboard/keys')->with('success','successfully deleted');
        }

        return back()->with('erorr','error not found');
    }
}
