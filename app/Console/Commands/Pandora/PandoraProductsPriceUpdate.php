<?php

namespace App\Console\Commands\Pandora;

use App\Models\Admin\Client;
use App\Models\Admin\Product;
use App\Models\Admin\ProductVariation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class PandoraProductsPriceUpdate extends Command
{
    private $pandoraUrl = 'http://54.237.51.171/api/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandora:products-price-update';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update price of products';

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
        $response = Http::post($this->pandoraUrl . 'Login', [
            'usuario' => 'IntegracaoWebAPI',
            'senha' => '1nt3gr4c40W3b4P1'
        ]);
        $pandora = Client::whereSlug('pandora')->first();
        if($pandora)
        {
            if($response->status() == 200) {
                $this->info("token obtained");
                $date = Carbon::now()->format('Y-m-d');
                $json = $response->json();

                     $products_api = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $json['token']
                    ])->get($this->pandoraUrl . 'Produtos/DataAlteracao=' . $date, []);

                if($products_api->status() == 200) {
                    echo 'list products obtained' . PHP_EOL;
                    $products = $products_api->json();

                    foreach($products as $product) {

                        $codProduct = explode('-', $product['produto']);
                        $sku = $product['echoCadProdutosSku'][0]['sku'];

                        //precio del producto
                        $products_price_api = Http::withHeaders([
                            'Authorization' => 'Bearer ' . $json['token']
                        ])->get($this->pandoraUrl . 'ProdutosPrecos/Sku=' . $sku, []);

                        $productPrice = $products_price_api->json();

                        if(Product::whereSku($codProduct[0])->count() > 0) {//existe en product table

                            //en caso de que ya exista el producto, lo actualizo
                            $this->info("update product");
                            $p = Product::whereSku($codProduct[0])->first();
                            $p->old_price = $p->price;
                            $p->price = $productPrice[0]['preco'];
                            $p->save();

                            if(isset($codProduct[1])) {//si existe el producto tiene medida o variaciones

                                if(ProductVariation::whereProduct($codProduct[0])->whereCod($codProduct[1])->count() > 0) {

                                    $this->info("update variations");
                                    $pro_var         =   ProductVariation::whereProduct($codProduct[0])
                                    ->whereCod($codProduct[1])
                                    ->whereSku(((explode($product['produto'], $sku))[1])) ->first();

                                    $pro_var->price    = $productPrice[0]['preco'];
                                    $pro_var->save();

                                }
                            }
                        }



                        echo 'product: ' . $product['produto'] . PHP_EOL;
                    }
                }
            }


            echo 'products verified' . PHP_EOL;
        }
        else {

            echo 'pandora client not found' . PHP_EOL;
        }
        return 0;
    }
}
