<?php

namespace App\Console\Commands\Pandora;

use App\Deliveries\Loggi\Loggi;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class PandoraLoggi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandora:loggi-auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'loggin into loggi';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*
        $url = 'http://apilanlimp.wiperagency.com/api/v1/';
        //$url = 'http://pandora.local/api/v1/';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url . "authenticate");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'username' => "lanlimp",
            'password' => 'hklj37j$h4'
        ));
        $curlData = curl_exec($curl);
        curl_close($curl);

        $curlData = json_decode($curlData, true);

        $token_access = $curlData['access_token'];
        echo $token_access . PHP_EOL;


        //$token_access = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9wYW5kb3JhLmxvY2FsXC9hcGlcL3YxXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE1OTgyOTkxMTEsIm5iZiI6MTU5ODI5OTExMSwianRpIjoic0RIUDVBTEE4aGpzSVVmSCIsInN1YiI6MywicHJ2IjoiNzIzNDlhZmZkYTA0NGRjMmFkNzBhMzllZjE1MTYzZWE2N2E3MzMxMyJ9.CKHBLm8wNpC56MoCeF03LPO2Irw5IQpxd1i_Bea0p-g';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url . "products/7959");
        curl_setopt($curl, CURLOPT_PUT, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT,30);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $token_access
        ));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
            'name'       => "FORRO P\/ ASSENTO SANITARIO 40FLS",
            'title'      => "FORRO P\/ ASSENTO SANITARIO 40FLS",
            'categories' => "ACESSORIOS PARA BANHEIRO",
            'weight'     => 0.17999999999999999,
            'price'      => 8.982
        )));

        $curlData = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        dd($curlData);
        curl_close($curl);
*/

        //getting apikey
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://staging.loggi.com/graphql/");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $headers = array(
            "Content-Type:application/json"
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $fields = array(
            'query' => 'mutation { login ( input:  { email: "mprios@pandora.net", password: "Loggi2020" }) { user { apiKey } } }'
        );

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        $curlData = curl_exec($curl);
        print_r("PRUEBA LOGIN-------------------------------------------");
        print_r(json_decode($curlData));

        $body = json_decode($curlData);
  //      print_r($body);

        $apiKey = $body->data->login->user->apiKey;
        curl_close($curl);


        //consult profile data
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://staging.loggi.com/graphql/");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $headers = array(
          "Authorization: ApiKey mprios@pandora.net:" . $apiKey,
            "Content-Type:application/json"

        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $fields = array(
            'query' => 'query { allShops { edges { node { name pickupInstructions pk address { pos addressSt addressData}chargeOptions { label } } } } }'
        );

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        $curlData = curl_exec($curl);
        print_r("PRUEBA 1-------------------------------------------");
        print_r(json_decode($curlData));

        curl_close($curl);

        //Estimar preços de pedido utilizando ponto fixo com lat/long
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://staging.loggi.com/graphql/");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $headers = array(
          "Authorization: ApiKey mprios@pandora.net:" . $apiKey,
            "Content-Type:application/json"

        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $fields = array(
            'query' => 'query {
                estimate(
                  shopId: 6522,
                  packagesDestination: [
                    {
                      lat: -23.5025491,
                      lng: -46.69607400000001
                    }
                  ]
                  chargeMethod: 1,
                  optimize: true
                ) {
                  normal {
                    cost
                    distance
                    eta
                  }
                }
              }'
        );

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        $curlData = curl_exec($curl);
        print_r("PRUEBA 2-------------------------------------------");
        print_r(json_decode($curlData));
        curl_close($curl);

        //Estimar preços de um pedido por endereço com roteirização
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://staging.loggi.com/graphql/");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $headers = array(
            "Content-Type:application/json",
            "Authorization: ApiKey mprios@pandora.net:" . $apiKey
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $fields = array(
            'query' => 'query {
                estimateCreateOrder(
                  shopId: 6522
                  pickups: [{
                    address: {
                      lat: -23.5703022
                      lng: -46.6473154
                      address: "Av. Paulista, 100 - Bela Vista, São Paulo - SP, Brasil"
                      complement: "8o andar"
                    }
                  }]
                  packages: [{
                    pickupIndex: 0
                    recipient: {
                      name: "Cliente A"
                      phone: "11912345678"
                    }
                    address: {
                      lat: -23.635334
                      lng: -46.529835
                      address: "Av. Estados Unidos, 505 - Parque das Nações, Santo André - SP, Brasil"
                      complement: "Apto 133"
                    }
                    dimensions: {
                      width: 44
                      height: 38
                      weight: 3000
                      length: 38
                    }
                    charge: {
                      value: "10.00"
                      method: 2
                      change: "5.00"
                    }
                  }, {
                    pickupIndex: 0
                    recipient: {
                      name: "Client B"
                      phone: "11987654312"
                    }
                    address: {
                      lat: -23.635334
                      lng: -46.529835
                      address: "Av. Brasil, 2000 - Jardim Paulista, São Paulo - SP, 01429-011"
                      complement: "Apto"
                    }
                    dimensions: {
                      width: 10
                      height: 10
                      weight: 1000
                      length: 1
                    }
                    charge: {
                      value: "10.00"
                      method: 2
                      change: "5.00"
                    }
                  }, {
                    pickupIndex: 0
                    recipient: {
                      name: "Client C"
                      phone: "11987656789"
                    }
                    address: {
                      lat: -23.635334
                      lng: -46.529835
                      address: "Rua Groenlândia, 12 - Jardim Europa, São Paulo - SP"
                      complement: "Apto 21"
                    }
                    dimensions: {
                      width: 10
                      height: 10
                      weight: 1000
                      length: 15
                    }
                  }]
              )  {
                  totalEstimate {
                    totalCost
                    totalEta
                    totalDistance
                  }
                  ordersEstimate {
                    packages {
                      isReturn
                      cost
                      eta
                      outOfCoverageArea
                      outOfCityCover
                      originalIndex
                      resolvedAddress
                      originalIndex
                    }
                    optimized {
                      cost
                      eta
                      distance
                    }
                  }
                  packagesWithErrors {
                    originalIndex
                    error
                    resolvedAddress
                  }
                }
              }'
        );

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        $curlData = curl_exec($curl);
        print_r("PRUEBA 3-------------------------------------------");
        print_r(json_decode($curlData));
        curl_close($curl);


    //    $loggi = new Loggi('mprios@pandora.net', '1234');
    //   $res = $loggi->config();


        $graphQLquery = '{"query": "query { viewer { repositories(last: 100) { nodes { name id isPrivate nameWithOwner } } } } "}';
        $url = 'https://staging.loggi.com/graphql/';

        echo 'doing Login with data: mprios@pandora.net Loggi2020' . PHP_EOL;
        $graphQLquery = 'mutation { login ( input:  { email: "mprios@pandora.net", password: "Loggi2020" }) { user { apiKey } } }';

        $response = (new Client)->request('post', $url, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'query' => $graphQLquery,
            ]),
        ]);

        $body = json_decode($response->getBody());
        $apiKey = $body->data->login->user->apiKey;

        echo 'api key: ' . $apiKey . PHP_EOL;
        $graphQLquery2 = '
        query {
            estimateCreateOrder(
              shopId: 6522
              pickups: [{
                address: {
                  address: "Av. Regente Feijó, 1739 - Tatuapé (Loja OQ 147)"
                  complement: ""
                }
              }]
              packages: [{
                pickupIndex: 0
                address: {
                  address: "Av. Estados Unidos, 505 - Parque das Nações, Santo André - SP, Brasil"
                  complement: "Apto 133"
                }
              }]
          )  {
              totalEstimate {
                totalCost
                totalEta
                totalDistance
              }
            }
          }
        ';

        $graphQLquery2 = "query { allShops { edges { node { name pickupInstructions pk address { pos addressSt addressData}chargeOptions { label } } } } }";
        $graphQLquery2 = "query { estimate( shopId: 6522, packagesDestination: [ { lat: -23.5025491, lng: -46.69607400000001 } ] chargeMethod: 1, optimize: true ) { packages { error eta index rideCm outOfCityCover outOfCoverageArea originalIndex waypoint { indexDisplay originalIndexDisplay role } } routeOptimized normal { cost distance eta } optimized { cost distance eta } } }";
        $graphQLquery2 = 'mutation {
            createOrder(input: {
              shopId: 6522
              trackingKey: "tracking_key"
              pickups: [{
                address: {
                  lat: -23.5703022
                  lng: -46.6473154
                  address: "Av. Paulista, 100 - Bela Vista, São Paulo - SP, Brasil"
                  complement: "8o andar"
                }
              }]
              packages: [{
                pickupIndex: 0
                recipient: {
                  name: "Client XYZ"
                  phone: "1199678890"
                }
                address: {
                  lat: -23.635334
                  lng: -46.529835
                  address: "Av. Estados Unidos, 500 - Parque das Nações, Santo André - SP, Brasil"
                  complement: "Apto 133"
                }
                charge: {
                  value: "10.00"
                  method: 2
                  change: "5.00"
                }
                dimensions: {
                  width: 10
                  height: 10
                  length: 10
                }
              }]
            }) {
              success
              shop {
                pk
                name
              }
              orders {
                pk
                trackingKey
                packages {
                  pk
                  status
                  pickupWaypoint {
                    index
                    indexDisplay
                    eta
                    legDistance
                  }
                  waypoint {
                    index
                    indexDisplay
                    eta
                    legDistance
                  }
                }
              }
              errors {
                field
                message
              }
            }
          }';


        $graphQLquery2 = 'mutation {
            createOrder(input: {
              shopId: 6522
              trackingKey: "tracking_key"
              pickups: [{
                address: {
                  lat: -46.6960692,
                  lng:  -23.6142521
                  address: "Av. Dr. Chucri Zaidan, 1550 - Santo Amaro, São Paulo - SP, 04711-130, Brazil"
                  complement: ""
                }
              }]
              packages: [{
                pickupIndex: 0
                recipient: {
                  name: "1040"
                  phone: "12345678"
                }
                address: {
                  address: "Alameda Gabriel Monteiro da Silva, 1445 - Jardim America, São Paulo - SP, 01441-002"
                  complement: ""
                }
                charge: {
                  value: "0.00"
                  method: 2
                  change: "0.00"
                }
                dimensions: {
                  width: 10
                  height: 10
                  length: 10
                }
              }]
            }) {
              success
              shop {
                pk
                name
              }
              orders {
                pk
                trackingKey
                packages {
                  pk
                  status
                  pickupWaypoint {
                    index
                    indexDisplay
                    eta
                    legDistance
                  }
                  waypoint {
                    index
                    indexDisplay
                    eta
                    legDistance
                  }
                }
              }
              errors {
                field
                message
              }
            }
          }';


        $response = (new Client)->request('post', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'ApiKey mprios@pandora.net:' . $apiKey
            ],
            'body' => json_encode(['query' => $graphQLquery2 ]),
        ]);


        $body = json_decode($response->getBody());


        echo 'products verified' . PHP_EOL;
        return 0;
    }
}
