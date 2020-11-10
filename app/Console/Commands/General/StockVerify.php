<?php

namespace App\Console\Commands\General;

use App\Models\Admin\Client;
use App\Models\Admin\Product;
use App\Models\Admin\Store;
use App\Models\Admin\StoreProduct;
use App\Models\GlobalStatus;
use Illuminate\Console\Command;

class StockVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stock of products';

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
        $clients = Client::get();

        foreach($clients as $client)
        {
            $totalProducts = Product::where('id_client', '=', $client->id)->whereStatus(GlobalStatus::STATUS_ACTIVE)->count();
            $stores = Store::where('id_client', '=', $client->id)->with('products')->get();

            foreach($stores as $store)
            {
                if($store->products->count() < $totalProducts) {//significa que la tienda actual le faltan productos
                    $list = StoreProduct::select('sku')->where('id_store', $store->id)->get()->toArray();//lista de productos asignados
                    $pRestantes = Product::where('id_client', '=', $client->id)->whereStatus(GlobalStatus::STATUS_ACTIVE)->whereNotIn('sku', $list)->get();

                    $insert = [];
                    foreach($pRestantes as $p) {
                        $insert[] = ['id_store' => $store->id, 'sku' => $p['sku']];
                    }

                    StoreProduct::insert($insert);//asigno los productos faltantes
                }

            }
        }

        echo 'stock verified' . PHP_EOL;
        return 0;
    }
}
