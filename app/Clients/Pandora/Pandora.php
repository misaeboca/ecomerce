<?php

namespace App\Clients\Pandora;

use App\Clients\Interfaces\IClientMethod;
use App\Clients\MainClientMethod;
use App\Models\Common\Store;
use App\Models\Common\StoreProduct;
use Illuminate\Support\Facades\Http;
use Exception;

class Pandora implements IClientMethod
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
                throw new Exception('erp client pandora no mode selected');
            break;
        }
    }

    public function getIdClient()
    {
        return MainClientMethod::CLIENT_PANDORA;
    }

    public function verifyStock($data)
    {
        $filial = Store::whereId($data['store'])->first();

        try
        {
            $response = Http::post($this->environment->getApiUrl(). 'Login', [
                'usuario' => 'IntegracaoWebAPI',
                'senha' => '1nt3gr4c40W3b4P1'
            ]);

            $token = null;
            if($response->status() == 200) {
                $json = $response->json();
                $token = $json['token'];
            }

            if($token)
            {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                ])->get($this->environment->getApiUrl() . 'EstoqueProdutos/Sku=' . $data['sku'], []);
                if($response->status() == 200)
                {
                    $body = $response->json();
                    foreach($body as $b)
                    {
                        if($filial->sigla == $b['filial'])
                        {
                            return $b['qtde'];
                        }
                    }
                }
            }

            return 0;

        } catch (\Exception $e)
        {
            logError('Pandora@verifyStock: ' . $e->getMessage());
            return 0;
        }
    }

    public function verifyStockLocal($data)
    {
        $filial = Store::whereId($data['store'])->first();

        try
        {
            $sp = StoreProduct::whereIdStore($data['store'])
            ->whereProduct($data['product']);

            if(isset($data['cod'])) {
                $sp = $sp->whereCod($data['cod']);
            }


            if(isset($data['sku'])) {
                $sp = $sp->whereSku($data['sku']);
            }

            $sp = $sp->get();

            return  $sp;

        } catch (\Exception $e)
        {
            logError('Pandora@verifyStock: ' . $e->getMessage());
            return ['stock' => 0];
        }
    }

    public function verifyStocksLocal($data)
    {
        $filial = Store::whereId($data['store'])->first();

        try
        {
            $sp = StoreProduct::whereIdStore($data['store'])
            ->whereProduct($data['product'])
            ->get();

            return $sp;

        } catch (\Exception $e)
        {
            logError('Pandora@verifyStock: ' . $e->getMessage());
            return [];
        }
    }

    public function notifyOrder($data)
    {

    }

    public function notifyRefund($data)
    {

    }

}
