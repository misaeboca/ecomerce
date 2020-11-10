<?php

namespace App\Deliveries\Ups;

use Exception;
use App\Deliveries\Interfaces\IDeliveryMethod;
use GuzzleHttp\Client;

class Ups 
{
    private $environment;
    private $api_key;
    private $shopId;
    private $address;
    private $distance;
    private $cedentials;

    public function __construct($clientId, $api_key = null, $shopId = 0)
    {
        $this->shopId = $shopId;
        $this->api_key = $api_key;

        switch(env('UPS_ENVIRONMENT_MODE')) {
            case 'sandbox':
                $this->environment = Environment::sandbox($clientId);
            break;

            case 'production':
                $this->environment = Environment::production($clientId);
            break;

            default:
                logError('ups no mode selected');
                $this->environment = Environment::sandbox($clientId);
                throw new Exception('ups no mode selected');
            break;
        }

    }

    public function setCredentials($data)
    {
        $this->credentials = new Credentials($data);
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    private function getHeaders()
    {
        $data = [
            'Content-Type' => 'application/json',
            'Username' => $this->credentials->getUsername(),
            'Password' => $this->credentials->getPassword(),
            'AccessLicenseNumber' => $this->credentials->setAccessLicenseNumber()
        ];
        return $data;
    }

    public function getBody() {


         $data["FreightShipRequest"] = [
            "Shipment" => [
                "ShipFrom": {
                    "Name": "Ship From Name",
                    "Address": {
                        "AddressLine": "AddressLine",
                        "City": "City",
                        "StateProvinceCode": "State",
                        "PostalCode": "PostalCode",
                        "CountryCode": "CountryCode"
                    },
                    "AttentionName": "AttentionName",
                    "Phone": {
                        "Number": "AttentionPhone"
                    }
                },
                "Service": {
                    "Code": "308"
                },

            ]
         ];

        return json_encode($data);
    }


}
