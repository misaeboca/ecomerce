<?php

namespace App\Console\Commands\Frigidaire;

use App\Models\Admin\Client;
use App\Models\Admin\Product;
use App\Models\Admin\Store;
use App\Models\Admin\StoreProduct;
use App\Models\GlobalStatus;
use Illuminate\Console\Command;

class FrigidaireStoresVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'frigidaire:stores-verify';

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
        $pandora = Client::whereSlug('frigidaire')->first();
        $totalProducts = Product::where('id_client', '=', $pandora->id)->whereStatus(GlobalStatus::STATUS_ACTIVE)->count();
        $stores = Store::where('id_client', '=', $pandora->id)->with('products')->get();

        foreach($stores as $store)
        {
            if($store->products->count() < $totalProducts) {//significa que la tienda actual le faltan productos
                $list = StoreProduct::select('sku')->where('id_store', $store->id)->get()->toArray();//lista de productos de la tienda id
                $pRestantes = Product::where('id_client', '=', $pandora->id)
                ->whereStatus(GlobalStatus::STATUS_ACTIVE)
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
