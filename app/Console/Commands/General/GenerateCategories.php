<?php

namespace App\Console\Commands\General;

use App\Models\Admin\Category;
use App\Models\Admin\Client;
use App\Models\Admin\Product;
use App\Models\GlobalStatus;
use Illuminate\Console\Command;

class GenerateCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'general:generate-category {client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'getting category tree';

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
        $products = Product::select('categories')->whereIdClient($client)->groupBy('categories')->orderBy('categories', 'asc')->get();

        foreach($products as $product)
        {
            //format of string categories cat1>cat1a,cat2>cat2a>cat2b,cat3
            $mainCategories = explode(',', $product['categories']);//for main categories cat1>cat1a, \n cat2>cat2a>cat2b, \n cat3

            foreach ($mainCategories as $mainCategory)
            {
                $categories = explode('>', $mainCategory);//for subcategories cat1>cat1a
                foreach($categories as $key => $category)
                {
                    $slug = generateSlug($category);
                    if(Category::whereSlug($slug)->count() == 0)
                    {
                        $cat = Category::create([
                            'id'=> generateUniqueId(),
                            'id_client' => $pandora->id,
                            'name' => $category,
                            'slug' => generateSlug($category),
                            'status' => GlobalStatus::STATUS_ACTIVE
                        ]);
                    }

                    if($key > 0)
                    {
                        $sslug = generateSlug($categories[$key-1]);
                        Category::whereSlug($slug)->update([
                            'id_category' => Category::whereSlug($sslug)->first()['id']
                        ]);
                    }
                }
            }
        }
        echo 'category tree updated' . PHP_EOL;
        return 0;
    }
}
