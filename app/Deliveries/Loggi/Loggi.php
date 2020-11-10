<?php

namespace App\Deliveries\Loggi;

use Exception;
use App\Deliveries\Interfaces\IDeliveryMethod;
use GuzzleHttp\Client;

class Loggi implements IDeliveryMethod
{

    private $environment;
    private $api_key;
    private $shopId;
    private $address;
    private $distance;
    private $free_amount;

    public function __construct($clientId, $api_key = null, $shopId = 0, $address = '', $distance = 0, $free_amount = 10000000)
    {
        $this->shopId = $shopId;
        $this->address = $address;
        $this->distance = $distance;
        $this->api_key = $api_key;
        $this->free_amount = $free_amount;

        switch(env('LOGGI_ENVIRONMENT_MODE')) {
            case 'sandbox':
                $this->environment = Environment::sandbox($clientId);
            break;

            case 'production':
                $this->environment = Environment::production($clientId);
            break;

            default:
                logError('loggi no mode selected');
                $this->environment = Environment::sandbox($clientId);
                throw new Exception('braspag no mode selected');
            break;
        }

    }

    public function config($data)
    {
        try
        {
            $graphQLquery2 = 'query { allShops { edges { node { name pickupInstructions pk address { pos addressSt addressData}chargeOptions { label } } } } }';

            $response2 = (new Client)->request('post', $this->environment->getApiUrl(), [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' =>'ApiKey '. $this->environment->getClientId() . ':' .  $data['apikey']
                ],
                'body' => json_encode([
                    'query' => $graphQLquery2,
                ]),
            ]);
            $body2 = json_decode($response2->getBody());
            $coordinates = json_decode($body2->data->allShops->edges[0]->node->address->pos)->coordinates;
            return json_decode('{"pk":' . $body2->data->allShops->edges[0]->node->pk . ', "api_key":"' . $data['apikey']. '", "coordinates": {"lat": ' . $coordinates[0] . ', "lng": ' . $coordinates[1] . '}}');

        } catch (\Exception $e)
        {
            logError('loggi error: ' . $e->getMessage());
            //return json_decode('{"pk": 6522, "api_key":"' . $apiKey . '", "coordinates": {"lat": -46.6960692, "lng": -23.6142521}}');
            return json_decode('{"pk": -1, "api_key":"' . $$data['apikey'] . '", "coordinates": {"lat": 0, "lng": 0}}');
        }
    }

    public function getQuotation($data)
    {
        $graphQLquery = '{ estimateCreateOrder( shopId: ' . $this->shopId . ' pickups: [{ address: { address: "' . $this->address . '" complement: "" } }] packages: [{ pickupIndex: 0 address: { address: "' . $data['address'] . '" complement: "" } }] ) { totalEstimate { totalCost totalEta totalDistance } } }';
        logInfo($graphQLquery);
        try
        {
            $response = (new Client)->request('post', $this->environment->getApiUrl(), [
                'headers' => $this->getHeaders(),
                'body' => json_encode(['query' => $graphQLquery ]),
            ]);

            $body = json_decode($response->getBody());

            if(is_null($body->data->estimateCreateOrder->totalEstimate))
            {
                return ['cost' => -1, 'distance' => -2];
            }

            return [
                'cost' => $body->data->estimateCreateOrder->totalEstimate->totalCost,
                'distance' => $body->data->estimateCreateOrder->totalEstimate->totalDistance,
                'time' => $body->data->estimateCreateOrder->totalEstimate->totalEta
            ];
        } catch (\Exception $e)
        {
            logError('Loggi: ' . $e->getMessage());
            return ['cost' => -1, 'distance' => -1];
        }

    }

    public function isFree($data)
    {
        return ($data['cost'] > $this->free_amount);
    }

    public function notifyDelivery($data)
    {
        $graphQLquery = 'mutation { createOrder(input: { shopId:  ' . $this->shopId . ' trackingKey: "' . $data['tracking_key'] . '"
              pickups: [{ address: { address: "' . $this->address . '" } }]
              packages: [{ pickupIndex: 0 recipient: { name: "' . $data['full_name'] . '" phone: "' . $data['phone'] . '" }
                address: { address: "' . $data['address'] . '" }
                charge: { value: "0.00" method: 2 change: "0.00" } }] }) { success shop { pk name } orders { pk trackingKey packages { pk status pickupWaypoint { index indexDisplay eta legDistance } waypoint { index indexDisplay eta legDistance } } } errors { field message } } }';

        $response = (new Client)->request('post', $this->environment->getApiUrl(), [
            'headers' => $this->getHeaders(),
            'body' => json_encode(['query' => $graphQLquery ]),
        ]);

        $body = json_decode($response->getBody());
        return $body;
    }

    public function trackingUrl($orderPk)
    {
        $graphQLquery = '{ retrieveOrderWithPk(orderPk: ' . $orderPk . ') { status statusDisplay originalEta totalTime pricing { totalCm } packages { pk shareds { edges { node { trackingUrl } } } } currentDriverPosition { lat lng currentWaypointIndex currentWaypointIndexDisplay } } }';
        logInfo($graphQLquery);
        $response = (new Client)->request('post', $this->environment->getApiUrl(), [
            'headers' => $this->getHeaders(),
            'body' => json_encode(['query' => $graphQLquery ]),
        ]);

        $body = json_decode($response->getBody());
        return $body;
    }

    public function getStoreData()
    {
        $graphQLquery = 'query { allShops { edges { node { name pickupInstructions pk address { pos addressSt addressData}chargeOptions { label } } } } }';

        $response = (new Client)->request('post', $this->environment->getApiUrl(), [
            'headers' => $this->getHeaders(),
            'body' => json_encode(['query' => $graphQLquery ]),
        ]);

        $body = json_decode($response->getBody());
        return json_decode($body->data->allShops->edges->node);
    }

    public function getDistance()
    {
        return $this->distance;
    }

    private function getHeaders()
    {
        $data = [
            'Content-Type' => 'application/json',
            'Authorization' =>'ApiKey '. $this->environment->getClientId() . ':' .  $this->api_key
        ];
        return $data;
    }

}
