<?php

namespace App\Deliveries\Ups;

use Exception;
use App\Deliveries\Interfaces\IDeliveryMethod;
use GuzzleHttp\Client;

class UpsDelivery
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

    public function getBodyFreight($data) {

         $data["FreightShipRequest"] = [
            "Shipment" => [
                "ShipFrom" => [
                    "Name"=> $data["ShipTo"]["name"],
                    "Address" => [
                        "AddressLine"=> $data["ShipTo"]["Address"]["AddressLine"],
                        "City"=> $data["ShipTo"]["Address"]["City"],
                        "StateProvinceCode"=> $data["ShipTo"]["Address"]["StateProvinceCode"],
                        "PostalCode" => $data["ShipTo"]["Address"]["PostalCode"],
                        "CountryCode" => $data["ShipTo"]["Address"]["CountryCode"]
                    ],
                    "AttentionName" => $data["ShipTo"]["Address"]["AttentionName"],
                    "Phone" => [ 
                        "Number" => $data["ShipTo"]["Address"]["AttentionPhone"]
                    ]
            ],
            "ShipperNumber": "888144",
            "ShipTo" => [
                "Name"=> $data["ShipTo"]["name"],
                "Address" => [
                    "AddressLine"=> $data$["ShipTo"]["Address"]["AddressLine"],
                    "City"=> $data["ShipTo"]["Address"]["City"],
                    "StateProvinceCode"=> $data["ShipTo"]["Address"]["StateProvinceCode"],
                    "PostalCode" => $data["ShipTo"]["Address"]["PostalCode"],
                    "CountryCode" => $data["ShipTo"]["Address"]["CountryCode"]
                ],
                "AttentionName" => $data["ShipTo"]["Address"]["AttentionName"],
                "Phone" => [ 
                    "Number" => $data["ShipTo"]["Address"]["AttentionPhone"]
                ]
            ],
            "PaymentInformation" => [
                "Payer" => [
                    "Name" => $data["PaymentInformation"]["Payer"]["PayerName"],
                    "Address" => [
                        "AddressLine" => $data["PaymentInformation"]["Payer"]["AddressLine"],
                        "City" => $data["PaymentInformation"]["Payer"]["City"],
                        "StateProvinceCode" => $data["PaymentInformation"]["Payer"]["StateProvince"],
                        "PostalCode" => $data["PaymentInformation"]["Payer"]["PostalCode"],
                        "CountryCode" => $data["PaymentInformation"]["Payer"]["CountryCode"]
                    ],
                    "ShipperNumber" => $data["PaymentInformation"]["Payer"]["ShipperNumber"],
                    "AccountType" => "1",
                    "AttentionName" => $data["PaymentInformation"]["Payer"]["AttentionName"],
                    "Phone" => [
                        "Number" => $data["PaymentInformation"]["Payer"]["Number"]
                    ]
                ],
                "ShipmentBillingOption" => [
                    "Code": "10"
                ]
            ],
            "Service" => [
                "Code": "308"
            ],
            "HandlingUnitOne" => [
                "Quantity"  => "2",
                "Type" => [
                    "Code": "PLT"
                ]
            ],
            "Commodity" => [
                "Description" => $data["PaymentInformation"]["Payer"]["Goods"],
                "Weight" => [
                    "UnitOfMeasurement" => [
                        "Code": "LBS"
                    ],
                    "Value": "190"
                ],
                "Dimensions" => [
                    "UnitOfMeasurement" => [
                        "Code" => "IN"
                    ],
                    "Length" => "11",
                    "Width" => "11",
                    "Height" => "11"
                ]  ,
                "NumberOfPieces" => "10",
                "PackagingType" => [
                    "Code": "PKG"
                ],
                "FreightClass" => "110"
            },
        
            "PickupRequest" => [
                "Requester" => [
                    "AttentionName" => "Jesus Lopez",
                    "EMailAddress": "jesus@gmail.com",
                    "Name" => "DG",
                    "Phone" => [
                        "Number" => "1234567"
                    ]
                ],
                "PickupDate" => "20181228"
            ]
            
         ];


        return json_encode($data);
    }

    public function getBodyPackage($data){

    }

    public function createD() {

        $client = new Client([
            'headers' => $this->getHeaders()
        ]);

        $response = $client->post($this->environment->getApiUrl(),
            ['body' => $this->getBody()]
        );
    
        if($response->getStatusCode() == 201)
        {
            $this->statusCode = 200;
            $body = json_decode($response->getBody());
        }

        print_r($body);
        exit;

    }

}
