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

    public function getBody($data) {

        $Shipment = $data["ShipmentRequest"]["Shipment"];
        $ShipFrom = $Shipment["ShipFrom"];
        $ShipTo   = $Shipment["ShipTo"];
        $PaymentInformation   = $Shipment["PaymentInformation"];
        $Package = $Shipment["Package"];
        $ShipmentRequest =  $data["ShipmentRequest"]["LabelSpecification"];


         $data["ShipmentRequest"] = [
            "Shipment" => [
                    "Description" => $Shipment["Description"],
                    "ShipFrom" => [
                        "Name" => $ShipFrom["Name"],
                        "Address" => [
                            "AddressLine" => $ShipFrom["Address"]["AddressLine"],
                            "City" =>        $ShipFrom["Address"]["City"],
                            "StateProvinceCode" =>  $ShipFrom["Address"]["State"],
                            "PostalCode" =>  $ShipFrom["Address"]["PostalCode"],
                            "CountryCode" =>  $ShipFrom["Address"]["CountryCode"]
                        ],
                        "AttentionName" =>  $ShipFrom["AttentionName"],
                        "Phone" => [
                            "Number" =>  $ShipFrom["Phone"]["AttentionPhone"]
                        ]
                    ],
                    "ShipTo" => [
                        "Name" => $ShipTo["Name"],
                        "Address" => [
                            "AddressLine" => $ShipTo["Address"]["AddressLine"],
                            "City" =>        $ShipTo["Address"]["City"],
                            "StateProvinceCode" =>  $ShipTo["Address"]["State"],
                            "PostalCode" =>  $ShipTo["Address"]["PostalCode"],
                            "CountryCode" =>  $ShipTo["Address"]["CountryCode"]
                        ],
                        "AttentionName" =>  $ShipTo["AttentionName"],
                        "Phone" => [
                            "Number" =>  $ShipTo["Phone"]["AttentionPhone"]
                        ]
                    ],
                    "PaymentInformation" => [
                        "ShipmentCharge" => [
                            "Type" =>  "01",
                            "BillShipper" => [
                                "AccountNumber" => $this->credentials->accountId()
                            ]
                        ]
                    ],
                    "Service" => [
                        "Code"=> "308"
                    ],
                    "Package" => [
                        [
                            "Description" => $Package["Description"],
                            "Packaging" => [
                                "Code" => $Package["Packaging"]["Code"]
                            ],
                            "PackageWeight" => [
                                "UnitOfMeasurement" => [
                                    "Code" =>  $Package["PackageWeight"]["UnitOfMeasurement"]["LBS"]
                                ],
                                "Weight" => $Package["PackageWeight"]["Weight"]
                            ],
                            "PackageServiceOptions"=> ""
                        ]
                    ],
                    "ItemizedChargesRequestedIndicator" => "",
                    "RatingMethodRequestedIndicator" => "",
                    "TaxInformationIndicator" => "",
                    "ShipmentRatingOptions" => [
                        "NegotiatedRatesIndicator" => ""
                    ]
                ],
      
            "LabelSpecification" => [
                "LabelImageFormat" => [
                    "Code" => "GIF"
                ]
            ]
        ];

        return json_encode($data);
    }

    public function processShipment(){
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
