<?php

namespace App\Console\Commands\Pandora;

use App\Models\Admin\Client;
use App\Models\Admin\Product;
use App\Models\Admin\Store;
use App\Models\Admin\StoreProduct;
use Illuminate\Console\Command;

class StoresVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandora:products-stores-verify {client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stores of products';

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
        $totalProducts = Product::whereidClient($pandora->id)->count();
        $stores = Store::whereIdClient($pandora->id)->with('products')->get();
        echo 'updating products stores' . PHP_EOL;
        foreach($stores as $store)
        {
            if($store->products->count() < $totalProducts) {//significa que la tienda actual le faltan productos
                $list = StoreProduct::select('sku')->whereIdStore($store->id)->get()->toArray();//lista de productos de la tienda id
                $pRestantes = Product::whereIdClient($pandora->id)
                ->with('variations')
                ->get();

                $insert = [];
                foreach($pRestantes as $product)
                {
                    foreach($product->variations as $p)
                    {
                        $insert[] = [
                            'id_store' => $store->id,
                            'product' => $p['product'],
                            'cod' => $p['cod'],
                            'sku' => $p['sku']
                        ];
                    }
                }

                StoreProduct::insert($insert);//asigno los productos faltantes
            }

        }

        echo 'stores verified' . PHP_EOL;
        return 0;
    }
}
