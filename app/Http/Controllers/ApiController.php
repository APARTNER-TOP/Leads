<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Log;
use App\Models\Api;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    protected static $api_sandbox = 'https://api.batscrm.com/leads-sandbox/sandbox';
    protected static $api_production = 'https://api.batscrm.com/leads';

    /**
     * Api send.
     *
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
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
        $response = Http::post(env('API_SANDBOX') ? self::$api_sandbox : self::$api_production, json_decode($json));
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
}
