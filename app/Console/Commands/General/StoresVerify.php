<?php

namespace App\Console\Commands\General;

use App\Models\Admin\Client;
use App\Models\Admin\Product;
use App\Models\Admin\Store;
use App\Models\Admin\StoreProduct;
use App\Models\GlobalStatus;
use Illuminate\Console\Command;

class StoresVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:verify';

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
        $clients = Client::get();

        try{

            foreach($clients as $client)
            {
                $totalProducts = Product::whereIdClient($client->id)->whereStatus(GlobalStatus::STATUS_ACTIVE)->count();

                $stores = Store::whereidClient($client->id)->get();

                foreach($stores as $store)
                {

                    if($store->products->count() < $totalProducts) {//significa que la tienda actual le faltan productos
                        $list = StoreProduct::select('product')
                        ->whereIdStore($store->id)
                        ->get()
                        ->toArray();//lista de productos asignados

                        $pRestantes = Product::whereIdClient($client->id)
                        ->whereStatus(GlobalStatus::STATUS_ACTIVE)
                        ->whereNotIn('sku', $list)
                        ->with('variations')
                        ->get();

                        $insert = [];
                        foreach($pRestantes as $p)
                        {
                            foreach($p->variations as $v)
                            {
                                $insert[] = [
                                    'id_store' => $store->id,
                                    'product' => $v['product'],
                                    'cod' => $v['cod'],
                                    'sku' => $v['sku'],
                                ];
                            }

                        }

                        StoreProduct::insert($insert);//asigno los productos faltantes
                    }

                }
        }
        } catch (\Exception $e)
            {
                logError($e->getMessage());
                return null;
            }

        echo 'stock verified' . PHP_EOL;
        return 0;
    }
}
