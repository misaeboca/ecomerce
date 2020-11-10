<?php

namespace App\Console\Commands\Pandora;

use App\Models\Admin\Client;
use App\Models\Admin\Product;
use App\Models\Admin\ProductVariation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class PandoraProductsUpdate extends Command
{
    private $pandoraUrl = 'http://54.237.51.171/api/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandora:products-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update fields of products';

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

                        if(Product::whereSku($codProduct[0])->count() <= 0) {//existe en product table
                            $this->info("New product");

                            $name = (!is_null($product['descricaoVitrine']) && $product['descricaoVitrine'] != 'NÃO INFORMADO.') ? $product['descricaoVitrine'] : $product['descricao'];
                            $description = (!is_null($product['detalhe']) && ($product['detalhe'] != 'NÃO INFORMADO.' ) ) ? $product['detalhe'] : $name;

                            $obj         = new Product();
                            $obj->name   = $name;
                            $obj->sku    = $codProduct[0];
                            $obj->html_short_description = $description;
                            $obj->ean13  = $product['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra'];
                            $obj->categories = $product['descGrupo'];
                            $obj->extra      =  json_encode($product);
                            $obj->id_client  =  $pandora->id;

                            $obj->save(); //save producto

                            //if have presentations
                            $pv         = new ProductVariation();
                            $pv->product= $codProduct[0];
                            $pv->cod    = 'U';
                            $pv->sku    = 'U';
                            $pv->price    = isset($productPrice[0]['preco']) ? $productPrice[0]['preco'] : 0;
                            $pv->description  = $product['detalhe'];
                            $pv->ean13 = isset($product['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra']) ? $product['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra'] : null;
                            $pv->extra      =  json_encode($product);

                            $pv->save();

                        }else{
                            //en caso de que ya exista el producto, lo actualizo
                            $this->info("update product");
                            $p = Product::whereSku($codProduct[0])->first();
                            $p->name = (!is_null($product['descricaoVitrine']) && $product['descricaoVitrine'] != 'NÃO INFORMADO.') ? $product['descricaoVitrine'] : $p['name'];
                            $p->html_short_description = (!is_null($product['detalhe']) && ($product['detalhe'] != 'NÃO INFORMADO.' ) ) ? $product['detalhe'] : $p['html_short_description'];
                            $p->categories =  $product['descGrupo'];

                            $p->save();


                            if(isset($codProduct[1])) {//si existe el producto tiene medida o variaciones

                                if(ProductVariation::whereProduct($codProduct[0])->whereCod($codProduct[1])->count() <= 0) {
                                    $this->info("create variations");
                                    $pro_var         = new ProductVariation();
                                    $pro_var->product= $codProduct[0];
                                    $pro_var->cod    = $codProduct[1];
                                    $pro_var->sku    = ((explode($product['produto'], $sku))[1]);
                                    $pro_var->price    = isset($productPrice[0]['preco']) ? $productPrice[0]['preco'] : 0;
                                    $pro_var->description  = $product['detalhe'];
                                    $pro_var->ean13 = isset($product['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra']) ? $product['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra'] : null;
                                    $pro_var->extra      =  json_encode($product);

                                    $pro_var->save();

                                }else {
                                    $this->info("update variations");
                                    $pro_var         =   ProductVariation::whereProduct($codProduct[0])
                                    ->whereCod($codProduct[1])
                                    ->whereSku(((explode($product['produto'], $sku))[1])) ->first();

                                    $pro_var->price    = isset($productPrice[0]['preco']) ? $productPrice[0]['preco'] : 0;
                                    $pro_var->description  = $product['detalhe'];
                                    $pro_var->ean13 = isset($product['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra']) ? $product['echoCadProdutosSku'][0]['echoCadProdutosBarra'][0]['codigoBarra'] : null;
                                    $pro_var->extra      =  json_encode($product);

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
