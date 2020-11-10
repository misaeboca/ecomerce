<?php

namespace App\Clients\Maskchain;

use App\Clients\Interfaces\IClientMethod;
use App\Clients\MainClientMethod;
use GuzzleHttp\Client;
use Exception;

class Maskchain implements IClientMethod
{
    private $environment;

    public function __construct()
    {
        switch(env('ERP_CLIENT_ENVIRONMENT_MODE')) {
            case 'sandbox':
                $this->environment = Environment::sandbox(['token' => 'L5f2b0174806b1']);
            break;

            case 'production':
                $this->environment = Environment::production(['token' => 'L5f2b0174806b1']);
            break;

            default:
                logError('erp client no mode selected');
                $this->environment = Environment::sandbox(['token' => 'L5f2b0174806b1']);
                throw new Exception('erp client lanlimp no mode selected');
            break;
        }
    }

    public function getIdClient()
    {
        return MainClientMethod::CLIENT_LANLIMP;
    }

    public function verifyStock($data)
    {
        try {
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);
            $response = $client->get($this->environment->getApiUrl() . $this->environment->getSessionToken() . '/products/' . $data['sku'] . '/stock');

            $body = json_decode($response->getBody());
            return $body->STOCK;
        } catch (\Exception $e)
        {
            logError('Lanlimp@verifyStock: ' . $e->getMessage());
            return 0;
        }

    }

    public function verifyStockLocal($data)
    {

    }

    public function verifyStocksLocal($data)
    {

    }

    public function notifyOrder($data)
    {
        try {
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);

            $products = [];
            foreach($data->products as $product)
            {
                $products [] = [
                    "sku" => $product->product,
                    "quantity" => $product->quantity
                ];
            }
            $response = $client->get($this->environment->getApiUrl() . $this->environment->getSessionToken() . '/order/',[

                "name" => $data->customer->name . ' ' . $data->customer->lastname ,
                "cpfcnpj" => $data->customer->cpf,
                "identity" => 11111111111,
                "phone" => $data->customer->phone,
                "email" => $data->customer->email,
                "street" => $data->customer->street,
                "house_number" => "10a",
                "complement" => $data->customer->address->complement,
                "neighborhood" => $data->customer->address->street,
                "city" => $data->customer->address->city,
                "state" => $data->customer->address->state,
                "cep" => 111111111,
                "country" => "BRA",
                "observation" => $data->observation,
                "payment" => "creditcard",
                "id_order" => $data->id,
                "id_order_custommer" => 11111111,
                "date_order" => $data->created_at,
                "delivery_price" => 0.00,
                "products" => $products

            ]);

            $body = json_decode($response->getBody());
            return ;
        } catch (\Exception $e)
        {
            logError('Lanlimp@verifyStock: ' . $e->getMessage());
            return 0;
        }
    }

    public function notifyRefund($data)
    {

    }
}
