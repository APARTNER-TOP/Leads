<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

use App\Models\Key;
use App\Models\LeadSource;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = DB::table('jobs')->paginate(10);
        \DB::disconnect();

        foreach ($jobs as $job) :
            $job->payload = json_decode($job->payload);
            $job->data = unserialize($job->payload->data->command);
            $job->data = $job->data->data;
        endforeach;

        return view('dashboard.queues.index', compact('jobs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $job = DB::table('jobs')->where('id', $id)->first();
        // $job->payload = json_decode($job->payload);
        // $job->data = unserialize($job->payload->data->command);
        // $job->data = $job->data->data;

        // \DB::disconnect();

        // return view('dashboard.queues.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = DB::table('jobs')->where('id', $id)->first();
        \DB::disconnect();

        if(!$job) {
            return back();
        }

        $job->payload = json_decode($job->payload);
        $job->data = unserialize($job->payload->data->command);
        $job->data = $job->data->data;

        $lead_type = $job->data['lead_type'];

        if($lead_type == 1) {
            $keys = Key::all();

            $key_id = DB::table('keys')
                        ->select('id')
                        ->where('key', '=', $job->data['key'])
                        ->first();

            \DB::disconnect();

            if (isset($key_id)) {
                $key_id = $key_id->id;
                $job->data['key_id'] = $key_id;
            }

            return view('dashboard.leads.lead', compact('lead_type', 'job', 'keys'));
        }

        if($lead_type == 2) {
            $lead_sources = LeadSource::all();

            return view('dashboard.leads.lead', compact('lead_type', 'job', 'lead_sources'));
        }

        $message = 'Invalid lead type';

        return back()
                ->withInput()
                ->with('error', $message);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if(DB::table('jobs')->where('id', $id)->delete()) {
        //     $message = 'Queue deleted successfully';
        //     return back()->with('success', $message);
        // }

        // \DB::disconnect();

        // $message = 'Queue deletion error';

        // return back()->with('error', $message);
    }
}
