<?php

namespace App\Clients\Frigidaire;

use App\Clients\Interfaces\IClientMethod;
use App\Clients\MainClientMethod;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Exception;

class Frigidaire implements IClientMethod
{
    private $environment;

    public function __construct()
    {
        switch(env('ERP_CLIENT_ENVIRONMENT_MODE')) {
            case 'sandbox':
                $this->environment = Environment::sandbox([]);
            break;

            case 'production':
                $this->environment = Environment::production([]);
            break;

            default:
                logError('erp client no mode selected');
                $this->environment = Environment::sandbox([]);
                throw new Exception('erp client frigidaire no mode selected');
            break;
        }
    }

    public function getIdClient()
    {
        return MainClientMethod::CLIENT_FRIGIDAIRE;
    }

    public function verifyStockLocal($data)
    {

    }

    public function verifyStocksLocal($data)
    {

    }

    public function verifyStock($data)
    {
        try
        {
        
            $response = Http::get($this->environment->getApiUrl() .'existencia/',
                [
                    "sucursal" => "003",
                    "articulo" => $data["sku"]
                ]
            );
            

            if($response->status() == 200)
            {
                return $response->json()[0]['existencia'];

            }else{
                return 0;
            }


        } catch (\Exception $e)
        {

            logError('Frigidaire@verifyStock: ' . $e->getMessage());
            return 0;
        }
    }

    public function notifyOrder($data)
    {
        try
        {
                $response = Http::post($this->environment->getApiUrl() . 'request/', [
                    $data
                ]);

                logInfo($this->environment->getApiUrl() . 'request='. $data['sucursal']);

                if($response->status() == 200)
                {
                    $body = $response->json()[0];

                    if(empty($body['numeroSolicitud']) && $body['numeroSolicitud'] != ""){
                        return json_decode($body);
                    }

                }else{
                    return 0;
                }


        } catch (\Exception $e)
        {
            logError('Frigidaire@verifyStock: ' . $e->getMessage());
            return 0;
        }
    }


    public function notifyRefund($data){


    }

}
