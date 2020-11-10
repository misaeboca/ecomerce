<?php

namespace Seeds\General;

use App\Models\Admin\Product;
use App\Models\Admin\Store;
use App\Models\Admin\StoreProduct;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StoreProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $stores = Store::all();
        $products = Product::all();

        foreach($stores as $store) {
            foreach($products as $product) {
                StoreProduct::create(
                    [
                        'sku' => $product->sku,
                        'id_store' =>  $store->id,
                        'stock' => $faker->numberBetween(0, 1000),
                ]);
            }
        }

    }
}
