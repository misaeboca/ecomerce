<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Shortener\StoreRequest;
use App\Models\Admin\ClientShortener;
use App\Models\Admin\Store;
use GuzzleHttp\Client;

class ShortenerController extends Controller
{
    public function generate(StoreRequest $request)
    {
        try
        {
            $data = $request->all();
            $store = Store::whereId($data['id_store'])->first();
            $clientShortener =  ClientShortener::whereIdClient($store->id_client)->first();

            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);
            $datos = [];

            if(isset($data['url'])){
                $datos['long_url']=$data['url'];
            }
            
            if(isset($data['body'])){
                $datos['body']=$data['body'];
            }
            $response = $client->post('http://byflexy.com/api/links/create?api_token=' . $clientShortener->api_key,
                [  
                     'body' => json_encode($datos) 
                ]
            );

            if($response->getStatusCode() == 200)
            {
                $body = json_decode($response->getBody());
                return response()->json(['state' => 'success', 'response' => $body->link->short_url], 200);
            }
            return response()->json(['state' => 'fail', 'response' => []], 200);
        }catch (\Exception $e) {
            logError('ShortenerController@generate: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 200);
        }
    }


}
