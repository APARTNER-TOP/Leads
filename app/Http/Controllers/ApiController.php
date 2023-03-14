<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Log;
use App\Models\Api;
use App\Models\LeadSource;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    //! api lead 1
    protected static $api1_sandbox = 'https://api.batscrm.com/leads-sandbox/sandbox';
    protected static $api1_production = 'https://api.batscrm.com/leads';

    /**
     * Leads1 Api send.
     *
     * @return \Illuminate\Http\Response
     */
    public function send1(Request $request)
    {
        $request->validate(
            [
                'key' =>'required|string|min:36|max:36',
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

        $json = Api::createJSON($request->all());
        $response = Http::post(config('settings.api_sandbox') ? self::$api1_sandbox : self::$api1_production, json_decode($json));
        $response_json = json_encode($response->body());

        //! throw error
        if ($response->failed()) {
            $res = json_decode($response->body());

            $status  = 'error';
            $code    = 423;
            $message = 'Unknown error';

            if (isset($res->Message)) {
                $message = $res->Message;

                if ($res->Message == 'Lead could not be processed, here are the details : These fields are required but are missing values in the incoming message: AuthKey') {
                    Log::saveData($status, $code, $request->all(), $response_json);

                    return back()
                        ->withInput()
                        ->with('error_key', $message . ' or an invalid authorization key');
                }
            } elseif (isset($res->error->message)) {
                $message = $res->error->message;
                $code    = $res->error->code;
            } else {
                if (isset($res->AuthKey) && $res->AuthKey == 'AuthKey is invalid. AuthKey is required.') {
                    $message = 'AuthKey is invalid. AuthKey is required.';

                    Log::saveData($status, $code, $request->all(), $response_json);

                    return back()
                        ->withInput()
                        ->with('error_key', $message);
                }

                $message = $res->error->message ?? $message;
            }

            Log::saveData($status, $code, $request->all(), $response_json);

            return back()
                ->withInput()
                ->with('error', $message);
        }

        //* Success send form
        $status  = 'success';
        $code    = 200;
        $message = $response->body();
        $message = 'Data sent successfully';

        Log::saveData($status, $code, $request->all(), $response_json);

        return back()->with('success', $message);
    }

    //! api lead 2
    protected static $api2 = 'http://64.227.60.37/api/email/lead';

    /**
     * Leads 2 Api send.
     *
     * @return \Illuminate\Http\Response
     */
    public function send2(Request $request)
    {
        $leads_type = 2;

        $request->validate(
            [
                'lead_source' =>'required|integer',
                'first_name' =>'required|string',
                'last_name' =>'required|string',
                'email' =>'required|email',
                'phone' =>'required|string',
                'ship_date' =>'required|date|date_format:Y-m-d',
                'transport_type' => 'required|integer|min:1',
                'origin_city' =>'required|string',
                'origin_state' =>'required|string',
                'origin_zip' =>'required|integer',
                'destination_city' =>'required|string',
                'destination_state' =>'required|string',
                'destination_zip' =>'required|integer',
                'vehicle_make' => 'required|string',
                'vehicle_model' => 'required|string',
                'vehicle_model_year' => 'required|integer|digits:4|min:1900|max:'.(date("Y")),
            ]
        );

        $token = $request->_token;
        $json = Api::createJSON($request->all(), 2);
        $result = $request->all();

        $lead_source = LeadSource::find($result['lead_source']);
        //! "Lead Source Name": "Lead Artisans\\/CarShip.com",

        $result['lead_source'] = 'name: '. $lead_source->name . ' email: '. $lead_source->email;

        $first_name = $result['first_name'];
        $last_name = $result['last_name'];
        $email = $result['email'];
        $phone = $result['phone'];
        $ship_date = $result['ship_date'];
        $transport_type = $result['transport_type'];
        $comment_from_shipper = $result['comment_from_shipper'];
        $origin_city = $result['origin_city'];
        $origin_state = $result['origin_state'];
        $destination_city = $result['destination_city'];
        $destination_state = $result['destination_state'];

        $vehicle_make = $result['vehicle_make'];
        $vehicle_model = $result['vehicle_model'];
        $vehicle_model_year = $result['vehicle_model_year'];
        $origin_postal_code = $result['origin_zip'];
        $destination_postal_code = $result['destination_zip'];

        //! start curl
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::$api2,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '[
                {
                    "First Name": "' . $first_name . '",
                    "Last Name": "' . $last_name . '",
                    "Email": "' . $email . '",
                    "Phone": "' . $phone . '",
                    "Shipper Comment": "' . $comment_from_shipper . '",
                    "Ship Date": "' . $ship_date . 'T00:00:00",
                    "Transport Type": "' . $transport_type . '",
                    "Origin City": "' . $origin_city . '",
                    "Origin State": "' . $origin_state . '",
                    "Origin Zip": "' . $origin_postal_code . '",
                    "Destination City": "' . $destination_city . '",
                    "Destination State": "' . $destination_state . '",
                    "Destination Zip": "' . $destination_postal_code . '",
                    "Vehicles": "' . $vehicle_model_year . '|' . $vehicle_make . '|' . $vehicle_model . '|Car",
                    "Lead Source Name": "' . $lead_source->name . '",
                    "Lead Source Email": "' . $lead_source->email . '"
                }
            ]',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Cookie: laravel_session_crm=KjKm00m7kWhPj9YIwCGfJYDTaZqkMqXwfEVOEndo; student=83748614; studentNoNav=1'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $res = json_decode($response);

        $status  = 'error';
        $code    = $res->status;
        $message = 'error';
        // $message = $res->message;

        if($res->status === 200 && $res->code === 'OK' ) {
            //* Success send form
            $status  = 'success';
            $code    = 200;
            $message = 'Data sent successfully';

            Log::saveData($status, $code, $result, $response, $leads_type);

            return back()->with('success', $message);
        } else {
            Log::saveData($status, $code, $result, $response, $leads_type);

            return back()
                ->withInput()
                ->with('error', $message);
        }
        //! end curl

        // $response = Http::post(env('API_SANDBOX') ? self::$api2 : self::$api2, json_decode($json));

        // $response_json = json_encode($response->body());

        // //! throw error
        // if ($response->failed()) {
        //     $res = json_decode($response->body());

        //     $status  = 'error';
        //     $code    = $res->status;
        //     $message = 'error';
        //     $message = $res->message;

        //     Log::saveData($status, $code, $result, $response_json, $leads_type);

        //     return back()
        //         ->withInput()
        //         ->with('error', $message);
        // }

        // //* Success send form
        // $status  = 'success';
        // $code    = 200;
        // $message = $response->body();
        // $message = 'Data sent successfully';

        // Log::saveData($status, $code, $result, $response_json, $leads_type);

        // return back()->with('success', $message);
    }
}
