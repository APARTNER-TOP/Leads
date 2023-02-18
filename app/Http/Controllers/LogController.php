<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\Check;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Check::isAdmin()) {
            return redirect('/dashboard');
        }

        $logs = Log::with("user")->paginate(10);

        return view('dashboard.logs.index', compact('logs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        if(!Check::isAdmin()) {
            return redirect('/dashboard');
        }

        $log->data = json_decode($log->data);
        $log->result = explode(',', $log->result);
        $result = [];

        foreach ($log->result as $value) {
            $result[] = str_replace(['\\', '{', '}', '"', 'Vehicles:', '[',']'],[''],$value);
        }

        $log->result = $result;

        return view('dashboard.logs.show', compact('log'));
    }
}
