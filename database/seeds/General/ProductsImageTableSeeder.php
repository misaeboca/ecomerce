<?php

namespace Seeds\General;

use App\Models\Admin\ProductImage;
use App\Models\Admin\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 100; $i++) {
            $products = Product::get()->random(100);
            foreach($products as $p) {
                ProductImage::create(
                [
                    'sku' => $p['sku'],
                    'url' => $faker->imageUrl(640, 480),
                    'id_image' => generateUniqueId()
                ]);
            }

        }

    }
}
