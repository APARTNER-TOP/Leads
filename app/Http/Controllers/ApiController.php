<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Log;

class ApiController extends Controller
{
    // protected static $api = 'https://api.batscrm.com/leads-sandbox/sandbox'; //! url for sandbox
    protected static $api = 'https://api.batscrm.com/leads'; //! url for production

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

        //! throw error
        if($response->failed()) {
            $res = json_decode($response->body());

            $status = 'error';
            $code = 423;
            $message = 'Unknown error';

            if (isset($res->Message)) {
                $message = $res->Message;

                if($res->Message == 'Lead could not be processed, here are the details : These fields are required but are missing values in the incoming message: AuthKey') {
                    Log::saveData($status, $code, $data, $response->body());

                    return back()
                        ->withInput()
                        ->with('error_key', $message .' or an invalid authorization key');
                }
            } elseif (isset($res->error->message)) {
                $message = $res->error->message;
                $code = $res->error->code;
            } else {
                if($res->AuthKey == 'AuthKey is invalid. AuthKey is required.') {
                    $message = 'AuthKey is invalid. AuthKey is required.';

                    Log::saveData($status, $code, $data, $response->body());

                    return back()
                        ->withInput()
                        ->with('error_key', $message);
                }

                $message = $res->error->message;
            }

            Log::saveData($status, $code, $data, $response->body());

            return back()
                ->withInput()
                ->with('error', $message);
        }

        //* Success send form
        $status = 'success';
        $code = 200;
        $message = $response->body();
        $message = 'Data sent successfully';

        Log::saveData($status, $code, $data, $response->body());

        return back()->with('success', $message);
    }
}
