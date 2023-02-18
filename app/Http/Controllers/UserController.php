<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use App\Models\Check;
use App\Models\User;

class UserController extends Controller
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

        $items = User::all();

        return view('dashboard.users.index', compact('items'));
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

        return view('dashboard.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_user' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => $request->type_user,
        ]);

        if($user->id) {
            return redirect('/dashboard')->with('success', 'User successfully created!');
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

        $user = User::find($id);

        return view('dashboard.users.profile.edit', compact('user'));
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

        $key = User::find($id);
        $key->fill($request->all());
        if($key->save()) {
            return redirect('/dashboard/users')->with('success', 'User update');
        }

        return back()->with('error','error not found');
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

        if($id == 1) {
            return back()->with('error','Disable delete this administrator');
        }

        if(User::find($id)->delete()) {
            return redirect('/dashboard/users')->with('success','User successfully deleted');
        }

        return back()->with('error','error not found');
    }
}
