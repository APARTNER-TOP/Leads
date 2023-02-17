<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    // protected static $api = 'https://api.batscrm.com/leads-sandbox/sandbox';
    protected static $api = 'https://api.batscrm.com/leads';

    /**
     * Api send.
     *
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $request->validate(
            [
                'key' =>'required|string',
                'first_name' =>'required|string',
                'email' =>'required|email',
                'phone' =>'required|string',
                'ship_date' =>'required|date|date_format:m/d/Y',
                'transport_type' => 'required|integer|min:1',
                'origin_postal_code' =>'required|integer',
                'destination_postal_code' =>'required',
                'vehicle_inop' => 'required|integer',
                'vehicle_make' => 'required|string',
                'vehicle_model' => 'required|string',
                'vehicle_model_year' => 'required|integer|digits:4|min:1900|max:'.(date("Y")),
            ]
        );

        $data = $request->all();
        unset($data['_token'], $data['_method']);

        $key = $data['key'];
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $comment_from_shipper = $data['comment_from_shipper'];
        $origin_city = $data['origin_city'];
        $origin_state = $data['origin_state'];
        $origin_postal_code = $data['origin_postal_code'];
        $origin_country = $data['origin_country'];
        $destination_city = $data['destination_city'];
        $destination_state = $data['destination_state'];
        $destination_postal_code = $data['destination_postal_code'];
        $destination_country = $data['destination_country'];
        $ship_date = $data['ship_date'];
        $transport_type = $data['transport_type'];

        $vehicle_inop = $data['vehicle_inop'];
        $vehicle_make = $data['vehicle_make'];
        $vehicle_model = $data['vehicle_model'];
        $vehicle_model_year = $data['vehicle_model_year'];

        $json = '{
            "AuthKey": "'. $key .'",
            "first_name": "'. $first_name .'",
            "last_name": "'. $last_name .'",
            "email": "'. $email .'",
            "phone": "'. $phone .'",
            "comment_from_shipper": "'. $comment_from_shipper .'",
            "origin_city": "'. $origin_city .'",
            "origin_state": "'. $origin_state .'",
            "origin_postal_code": "'. $origin_postal_code .'",
            "origin_country": "'. $origin_country .'",
            "destination_city": "'. $destination_city .'",
            "destination_state": "'. $destination_state .'",
            "destination_postal_code": "'. $destination_postal_code .'",
            "destination_country": "'. $destination_country .'",
            "ship_date": "'. $ship_date .'",
            "transport_type": '. $transport_type .',
            "Vehicles": [
                {
                    "vehicle_inop": '. $vehicle_inop .',
                    "vehicle_make": "'. $vehicle_make .'",
                    "vehicle_model": "'. $vehicle_model .'",
                    "vehicle_model_year": '. $vehicle_model_year .',
                    "vehicle_type": ""
                }
            ]
        }';

        // dd($data);

        // $response = Http::accept('application/json')->post(self::$api, $json)->json();
        $response = Http::post(self::$api, $json);

        //! get all data
        // $request->all();

        //! throw error
        if(!$response->successful() && $response->status() != 200) {
            $res = json_decode($response->body());

            if($res->Message) {
                $message = $res->Message;

                return back()->with('error', $message);
            }

            $message = $res->error->message;

            return back()->with('error', $res->error->message);
        }

        //! code ok

        dd($response->body());
        return back()->with('success', $res->message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
