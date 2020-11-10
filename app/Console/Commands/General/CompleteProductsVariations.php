<?php

namespace App\Console\Commands\General;

use App\Models\Admin\Product;
use App\Models\Admin\ProductVariation;
use App\Models\GlobalStatus;
use Illuminate\Console\Command;

class CompleteProductsVariations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'general:products-variations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'complete products tree';

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
        $pv = ProductVariation::pluck('product');

        $products = Product::whereStatus(GlobalStatus::STATUS_ACTIVE)->whereNotIn('sku', $pv)->withTrashed()->get();

        foreach($products as $product)
        {
            ProductVariation::create([
                'product' => $product['sku'],
                'cod' => 'U',
                'sku' => 'U',
                'price' => isset($product['price']) ? $product['price'] : 0,
                'description' => $product['html_description'],
                'ean13' => isset($product['ean13']) ? $product['ean13'] : null
            ]);
        }
        echo 'complete products tree' . PHP_EOL;
        return 0;
    }
}
