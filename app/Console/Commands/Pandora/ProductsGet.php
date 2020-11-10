<?php

namespace App\Console\Commands\Pandora;

use App\Models\Admin\Client;
use App\Models\Admin\Product;
use App\Models\Admin\ProductVariation;
use App\Models\GlobalStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ProductsGet extends Command
{
    private $pandoraUrl = 'http://54.237.51.171/api/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandora:products-get {client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get list of products';

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
        $client = $this->argument("client");
        $pandora = Client::whereSlug($client)->first();

        echo 'getting products' . PHP_EOL;
        $response = Http::post($this->pandoraUrl . 'Login', [
            'usuario' => 'IntegracaoWebAPI',
            'senha' => '1nt3gr4c40W3b4P1'
        ]);

        if($response->status() == 200) {
            echo 'token obtained' . PHP_EOL;
            $date = '1900-01-01';
            //$date = '2020-10-09';
            $json = $response->json();

            $response2 = Http::withHeaders([
                'Authorization' => 'Bearer ' . $json['token']
            ])->get($this->pandoraUrl . 'Produtos/DataAlteracao=' . $date, []);

            if($response2->status() == 200) {
                echo 'list products obtained' . PHP_EOL;
                $productos = $response2->json();

                foreach($productos as $producto)
                {
                    $codProducto = explode('-', $producto['echoCadProdutosSku'][0]['sku']);

                    $response = Http::post($this->pandoraUrl . 'Login', [
                        'usuario' => 'IntegracaoWebAPI',
                        'senha' => '1nt3gr4c40W3b4P1'
                    ]);

                    $json2 = $response->json();

                    $response2 = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $json2['token']
                    ])->get($this->pandoraUrl . 'ProdutosPrecos/Sku=' . $producto['echoCadProdutosSku'][0]['sku'], []);

                    $produtosPrecos = $response2->json();

                    if(Product::whereSku($codProducto[0])->count() <= 0)
                    {//main product
                        $name = (!is_null($producto['descricaoVitrine']) && $producto['descricaoVitrine'] != 'NÃO INFORMADO.') ? $producto['descricaoVitrine'] : $producto['descricao'];
                        $description = (!is_null($producto['detalhe']) && ($producto['detalhe'] != 'NÃO INFORMADO.' ) ) ? $producto['detalhe'] : $name;

                        Product::create([
                            'name' => $name,
                            'sku' => $codProducto[0],
                            'codProduct' => $producto['produto'],
                            'html_short_description' => $description,
                            'categories' => $producto['descGrupo'],
                            'extra' => json_encode($producto),
                            'id_client' => $pandora->id,
                            'status' => GlobalStatus::STATUS_ACTIVE
                        ]);

                        ProductVariation::create([
                            'product' => $codProducto[0],
                            'cod' => 'U',
                            'sku' => 'U',
                            'price' => isset($produtosPrecos[0]['preco']) ? $produtosPrecos[0]['preco'] : 0,
                            'description' => $producto['detalhe'],
                            'ean13' => isset($producto['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra']) ? $producto['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra'] : null,
                            'extra' => json_encode($producto),
                            'launch' => $producto['dataCadastramento']
                        ]);
                    }

                    $p = Product::whereSku($codProducto[0])->first();

                    $p->update([
                        'name' => (!is_null($producto['descricaoVitrine']) && $producto['descricaoVitrine'] != 'NÃO INFORMADO.') ? $producto['descricaoVitrine'] : $p['name'],
                        'html_short_description' => (!is_null($producto['detalhe']) && ($producto['detalhe'] != 'NÃO INFORMADO.' ) ) ? $producto['detalhe'] : $p['html_short_description'],
                        'categories' => $producto['descGrupo']
                    ]);

                    if(isset($codProducto[1])) {//si existe el producto tiene medida o variaciones 1234567-50001
                        if(ProductVariation::whereProduct($codProducto[0])->whereCod($codProducto[1])->count() <= 0) {
                            ProductVariation::create([
                                'product' => $codProducto[0],//1234567
                                'cod' => substr($codProducto[1], 0, 2),//50
                                'sku' => ((explode($producto['produto'], $producto['echoCadProdutosSku'][0]['sku']))[1]),//001
                                'price' => isset($produtosPrecos[0]['preco']) ? $produtosPrecos[0]['preco'] : 0,
                                'description' => $producto['detalhe'],
                                'ean13' => isset($producto['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra']) ? $producto['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra'] : $p['ean13'],
                                'extra' => json_encode($producto),
                                'launch' => $producto['dataCadastramento']
                            ]);
                        }
                        else {
                            ProductVariation::whereProduct($codProducto[0])
                            ->whereCod(substr($codProducto[1], 0, 2))
                            ->whereSku(((explode($producto['produto'], $producto['echoCadProdutosSku'][0]['sku']))[1]))
                            ->update([
                                'price' => isset($produtosPrecos[0]['preco']) ? $produtosPrecos[0]['preco'] : 0,
                                'description' => $producto['detalhe'],
                                'ean13' => isset($producto['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra']) ? $producto['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra'] : $p['ean13'],
                                'extra' => json_encode($producto),
                                'launch' => $producto['dataCadastramento']
                            ]);
                        }
                    }

                    //echo 'product: ' . $producto['produto'] . PHP_EOL;
                }

            }
        }


        echo 'products verified' . PHP_EOL;
        return 0;
    }
}
