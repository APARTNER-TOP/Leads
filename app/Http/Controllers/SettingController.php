<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Check;

class SettingController extends Controller
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

        return view('dashboard.settings.index');
    }
}
