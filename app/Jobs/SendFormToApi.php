<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Http;
use App\Models\Log;
use App\Models\Api;
use App\Models\LeadSource;

// use Illuminate\Contracts\Queue\Job; //! don't need

class SendFormToApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    //! api lead 1
    protected static $api1_sandbox = 'https://api.batscrm.com/leads-sandbox/sandbox';
    protected static $api1_production = 'https://api.batscrm.com/leads';

    /**
     * Leads1 Api send.
     *
     * @return \Illuminate\Http\Response
     */
    public function send1($request)
    {
        $json = Api::createJSON($request);
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
                    Log::saveData($status, $code, $request, $response_json);

                    return back()
                    ->withInput()
                    ->with('error_key', $message . ' or an invalid authorization key');
                    return false;
                }
            } elseif (isset($res->error->message)) {
                $message = $res->error->message;
                $code    = $res->error->code;
            } else {
                if (isset($res->AuthKey) && $res->AuthKey == 'AuthKey is invalid. AuthKey is required.') {
                    $message = 'AuthKey is invalid. AuthKey is required.';

                    Log::saveData($status, $code, $request, $response_json);

                    return back()
                        ->withInput()
                        ->with('error_key', $message);
                    return false;
                }

                $message = $res->error->message ?? $message;
            }

            Log::saveData($status, $code, $request, $response_json);

            return back()
                ->withInput()
                ->with('error', $message);
            return false;
        }

        //* Success send form
        $status  = 'success';
        $code    = 200;
        $message = $response->body();
        $message = 'Data sent successfully';

        Log::saveData($status, $code, $request, $response_json);

        return back()->with('success', $message);
        return true;
    }

    //! api lead 2
    protected static $api2 = 'http://64.227.60.37/api/email/lead';
    protected static $api2_sandbox = 'https://api.batscrm.com/leads-sandbox/sandbox';
    // protected static $api2 = 'http://64.227.60.37/api/email/leads'; //! for test

    /**
      * Leads 2 Api send.
      *
      * @return \Illuminate\Http\Response
      */
    public function send2($request)
    {
        $leads_type = 2;

        $result = $request;

        $lead_source = LeadSource::find($result['lead_source']);
        //! "Lead Source Name": "Lead Artisans\\/CarShip.com",

        $result['lead_source'] = 'name: ' . $lead_source->name . ' email: ' . $lead_source->email;

        $first_name           = $result['first_name'];
        $last_name            = $result['last_name'];
        $email                = $result['email'];
        $phone                = $result['phone'];
        $ship_date            = $result['ship_date'];
        $transport_type       = $result['transport_type'];
        $comment_from_shipper = $result['comment_from_shipper'];
        $origin_city          = $result['origin_city'];
        $origin_state         = $result['origin_state'];
        $destination_city     = $result['destination_city'];
        $destination_state    = $result['destination_state'];

        $vehicle_make            = $result['vehicle_make'];
        $vehicle_model           = $result['vehicle_model'];
        $vehicle_model_year      = $result['vehicle_model_year'];
        $origin_postal_code      = $result['origin_zip'];
        $destination_postal_code = $result['destination_zip'];

        //! start curl
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => config('settings.api_sandbox') ? self::$api2_sandbox : self::$api2,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => '[
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
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Cookie: laravel_session_crm=KjKm00m7kWhPj9YIwCGfJYDTaZqkMqXwfEVOEndo; student=83748614; studentNoNav=1',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $res = json_decode($response);

        $status  = 'error';
        $code    = $res->status;
        $message = 'error';
        // $message = $res->message;

        if ($res->status === 200 && $res->code === 'OK') {
            //* Success send form
            $status  = 'success';
            $code    = 200;
            $message = 'Data sent successfully';

            Log::saveData($status, $code, $result, $response, $leads_type);

            return back()->with('success', $message);
            return true;
        } else {
            Log::saveData($status, $code, $result, $response, $leads_type);

            return back()
                ->withInput()
                ->with('error', $message);
            return false;
        }
         //! end curl


         //! start first example code
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

         //! end first example code
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lead_type = $this->data['lead_type'];

        try {
            if($lead_type == 1) {
                $this->send1($this->data);
            } else {
                $this->send2($this->data);
            }
        } catch (\Exception $e) {
            // mark the job as failed and set the exit code
            $this->data->fail($e);
            $this->data->delete();
            $this->failed($e); // re-queue the job with a delay
            return 1; // set exit code to 1
        }

        // info($this->data);
    }

    public function failed($exception)
    {
        // Mail::to('admin@example.com')->send(new JobFailedNotification($exception, $this->getExitCode()));

        $delay = now()->addMinutes(5);
        $this->release($delay); // re-queue the job with a delay
    }
}
