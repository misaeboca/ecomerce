<?php

namespace App\Console\Commands\Pandora\Threads;

use Illuminate\Support\Facades\Http;
use DB;

class StockVerify
{
    private $pandoraUrl = 'http://54.237.51.171/api/';
    private $store;

    public function __construct($store)
    {
        $this->store = $store;
    }

    public function run()
    {
        echo 'getting token for store: ' . $this->store->sigla . PHP_EOL;
        $response = Http::post($this->pandoraUrl . 'Login', [
            'usuario' => 'IntegracaoWebAPI',
            'senha' => '1nt3gr4c40W3b4P1'
        ]);

        $json = $response->json();
        $token = $json['token'];

        echo 'getting stock for store: ' . $this->store->sigla . PHP_EOL;
        $response2 = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->pandoraUrl . 'EstoqueProdutos/Filial=' . $this->store->sigla, []);

        if($response2->status() == 200)
        {
            $body = $response2->json();
            $update = "";
            $count = 0;
            foreach($body as $b)
            {
                try {
                    $codProducto = explode('-', $b['produto']);
                    $codProducto2 = explode($b['produto'], $b['sku']);
                    $cod = isset($codProducto[1]) ? $codProducto[1] : 'U';
                    $sku = isset($codProducto2[1]) ? $codProducto2[1] : 'U';
                    $update .= " UPDATE". ' stores_products SET stock = ' . $b['qtde'] . ' WHERE id_store = "' . $this->store->id . '"  AND product = "' . $codProducto[0] . '" AND sku = "' . $sku . '" AND cod = "' . $cod . '";' ;

                    if($count > 1000)
                    {
                        DB::raw($update);
                        $update = "";
                        $count = 0;
                    }
                    $count++;
                } catch (\Exception $e) {
                    logError('PandoraStockVerify@handle: ' . $e->getMessage() . ' id_store: ' . $this->store->id . ' producto ' . $b['produto']);
                    return;
                }
            }
            echo 'end store '. PHP_EOL;
            DB::raw($update);
        }

        echo 'stock verified for ' . $this->store->id . PHP_EOL;
        return 0;
    }
}
