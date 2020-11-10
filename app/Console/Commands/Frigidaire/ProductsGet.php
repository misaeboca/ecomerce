<?php

namespace App\Console\Commands\Frigidaire;

use App\Models\Admin\Client;
use App\Models\Admin\Product;
use App\Models\Admin\ProductVariation;
use App\Models\GlobalStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ProductsGet extends Command
{
    private $url = 'http://190.167.212.137:8089/application/api/v1/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'frigidaire:products-get';

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

//        $response = Http::get($this->url . 'valorarticulos/?sucursal=003', []);
        $articulos = [
            "EF-FKGJ24C3MQG", "EF-FKGH30C3MDQG", "EF-FCRL3052AS",
            "EF-GCRG3038AF", "EF-FNGD90JWWS", "NF-FRTM25G3HPS", "NF-FRTS10G3HRS", "NF-FRTS15K3HRS",
            "NF-FRTS17V3HRS",  "LF-FWIV12D3OSGW",  "LF-FWIB18M4EBGS",  "HMF-FMDO17S3GSW",  "HMF-FMDO20S3GSP",  "HMF-FMDO30S3GSG"
        ];
        $client = Client::whereSlug('frigidaire')->first();
        foreach($articulos as $art)
        {

            $response = Http::get($this->url . 'valorarticulos/?sucursal=003&articulo=' . $art);

            if($response->status() == 200)
            {
                echo 'product obtained' . PHP_EOL;
                if(isset($response->json()[0]))
                {
                    $producto = $response->json()[0];

                    if(Product::whereSku($producto["sku"])->count() <= 0)
                    {//main product
                        Product::create([
                            'name' => $producto['nomPro'],
                            'sku' => $producto['sku'],
                            'codProduct' => $producto['codPro'],
                            'categories' => $producto['categ'],
                            'extra' => json_encode($producto),
                            'id_client' => $client->id,
                            'status' => GlobalStatus::STATUS_ACTIVE
                        ]);

                        ProductVariation::create([
                            'product' => $producto['sku'],
                            'cod' => 'U',
                            'sku' => 'U',
                            'price' => $producto['precioLstM1'],
                            'description' => $producto['descripcionCorta'],
                            'launch' => $producto['creacion']
                        ]);
                    }

                    $p = Product::whereSku($producto["sku"])->first();
                    $p->update([
                        'name' => (!is_null($producto['nomPro'])) ? $producto['nomPro'] : $p['name'],
                        'categories' => $producto['categ'],
                    ]);
                    ProductVariation::whereProduct($producto['sku'])
                    ->whereCod('U')
                    ->whereSku('U')
                    ->update(
                        [
                            'price' => $producto['precioLstM1'],
                            'description' => $producto['descripcionCorta'],
                            'launch' => $producto['creacion']
                        ]
                    );
                }
            }
        }

        return 0;
    }
}
