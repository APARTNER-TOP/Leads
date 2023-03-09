<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LeadSource;

class Api extends Model
{
    use HasFactory;

    public static function createJSON($data, $lead_api = 1)
    {
        unset($data['_token'], $data['_method']);

        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $ship_date = $data['ship_date'];
        $transport_type = $data['transport_type'];
        $comment_from_shipper = $data['comment_from_shipper'];
        $origin_city = $data['origin_city'];
        $origin_state = $data['origin_state'];
        $destination_city = $data['destination_city'];
        $destination_state = $data['destination_state'];

        $vehicle_make = $data['vehicle_make'];
        $vehicle_model = $data['vehicle_model'];
        $vehicle_model_year = $data['vehicle_model_year'];

        if ($lead_api === 1) {
            $key = $data['key'];
            $origin_postal_code = $data['origin_postal_code'];
            $origin_country = $data['origin_country'];
            $destination_postal_code = $data['destination_postal_code'];
            $destination_country = $data['destination_country'];

            $vehicle_inop = $data['vehicle_inop'];

            $json = '{
                "AuthKey": "' . $key . '",
                "first_name": "' . $first_name . '",
                "last_name": "' . $last_name . '",
                "email": "' . $email . '",
                "phone": "' . $phone . '",
                "comment_from_shipper": "' . $comment_from_shipper . '",
                "origin_city": "' . $origin_city . '",
                "origin_state": "' . $origin_state . '",
                "origin_postal_code": "' . $origin_postal_code . '",
                "origin_country": "' . $origin_country . '",
                "destination_city": "' . $destination_city . '",
                "destination_state": "' . $destination_state . '",
                "destination_postal_code": "' . $destination_postal_code . '",
                "destination_country": "' . $destination_country . '",
                "ship_date": "' . $ship_date . '",
                "transport_type": ' . $transport_type . ',
                "Vehicles": [
                    {
                        "vehicle_inop": ' . $vehicle_inop . ',
                        "vehicle_make": "' . $vehicle_make . '",
                        "vehicle_model": "' . $vehicle_model . '",
                        "vehicle_model_year": ' . $vehicle_model_year . ',
                        "vehicle_type": ""
                    }
                ]
            }';
        } else if ($lead_api === 2) {

            $lead_source = LeadSource::find($data['lead_source']);
            $origin_postal_code = $data['origin_zip'];
            $destination_postal_code = $data['destination_zip'];

            $json = '{
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
            ';
        }

        return $json;
    }
}
