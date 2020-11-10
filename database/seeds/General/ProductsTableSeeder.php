<?php

namespace Seeds\General;

use App\Models\GlobalStatus;
use App\Models\Admin\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 1000; $i++) {
            Product::create(
                [
                'name' => $faker->name,
                'sku' => generateUniqueId(),
                'categories' => $faker->randomElements(array('category_1,category_2','category_1,category_3','category_2,category_4', 'category_3,category_4'), 1)[0],
                'type' => $faker->randomElements(array('type_a','type_b','type_c', 'type_d'), 1)[0],
                'material' => $faker->randomElements(array('material_a','material_b','material_c', 'material_d'), 1)[0],
                'theme' => $faker->randomElements(array('theme_a','theme_b','theme_c', 'theme_d'), 1)[0],
                'alternative_names' => $faker->name,
                'html_description' => $faker->randomHtml(2,3),
                'html_short_description' => $faker->randomHtml(2,3),
                'weight' => $faker->randomFloat(NULL, 0, 1000),
                'height' => $faker->randomFloat(NULL, 0, 1000),
                'width'  =>  $faker->randomFloat(NULL,  0, 1000),
                'length' => $faker->numberBetween(100, 1000),
                'title' => $faker->jobTitle,
                'price' => $faker->randomFloat(NULL, 0, 9999999),
                'sale_price' => $faker->randomFloat(NULL, 0, 9999999) + $faker->randomFloat(NULL, 0, NULL),
                'old_price' => $faker->boolean(50) ? null : $faker->randomFloat(NULL, 0, NULL),
                'manufacturer' => $faker->jobTitle,
                'ean13' => $faker->ean13,
                'status' => GlobalStatus::STATUS_ACTIVE
            ]);
        }

    }
}
