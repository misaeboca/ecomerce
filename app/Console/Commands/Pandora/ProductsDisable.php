<?php

namespace App\Console\Commands\Pandora;

use App\Models\Admin\Client;
use App\Models\GlobalStatus;
use App\Models\Admin\Product;
use Illuminate\Console\Command;

class ProductsDisable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandora:products-disable {client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'disable bad products';

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
        echo 'products disabled run' . PHP_EOL;

        $products = Product::select('products.*')
        ->where('products.id_client', '=', $client)
        ->join('products_variations as pv', 'pv.product', '=', 'products.sku')
        ->where('pv.price', '=', 0)
        ->orWhereNull('pv.price')
        ->orWhereNull('products.categories')
        ->orWhere('products.categories', 'NÃO INFORMADO.')
        ->orWhere('products.categories', 'INDEFINIDO')
        ->get();

        foreach($products as $product)
        {
            if($product['price'] == null || $product['price'] == 0 || $product['categories'] == null || $product['categories'] == 'NÃO INFORMADO.' || $product['categories'] == 'INDEFINIDO')
            {
                Product::whereSku($product['sku'])->update(['status' => GlobalStatus::STATUS_INACTIVE]);
            }
        }

        echo 'products disabled' . PHP_EOL;
        return 0;
    }
}
