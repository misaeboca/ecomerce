<?php

namespace App\Console\Commands\General;

use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory as ProductCategoryModel;
use App\Models\GlobalStatus;
use Illuminate\Console\Command;

class ProductsCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'general:products-category {client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'link category tree';

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
        $client = $this->argument('client');
        $products = Product::whereIdClient($client)->get();

        foreach($products as $product)
        {
            //format of string categories cat1>cat1a,cat2>cat2a>cat2b,cat3
            $mainCategories = explode(',', $product['categories']);//for main categories cat1>cat1a, \n cat2>cat2a>cat2b, \n cat3
            foreach ($mainCategories as $mainCategory)
            {
                $categories = explode('>', $mainCategory);//for subcategories cat1>cat1a
                foreach($categories as $category)
                {
                    $cat = Category::whereSlug($category)->first();
                    if($cat){
                        ProductCategoryModel::create([
                            'product' => $product['sku'],
                            'id_category' => $cat->id
                        ]);
                    }
                }
            }
        }
        echo 'category tree updated' . PHP_EOL;
        return 0;
    }
}
