<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;

    public static function createJSON($data) {
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

        return $json;
    }
}
