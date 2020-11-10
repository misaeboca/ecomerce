<?php

namespace Seeds\General;

use App\Models\Admin\Order;
use App\Models\Admin\OrderProduct;
use App\Models\Admin\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach($orders = Order::all() as $order) {
            $product = Product::get()->random(1)[0];
            $cant = $faker->numberBetween(1, 1000);
            OrderProduct::create(
                [
                    'id_order' => $order->id,
                    'sku' => $product['sku'],
                    'price' => $product['price'],
                    'cant' => $cant,
                    'task' => 0.0,
                    'discount' => 0.0,
                    'total' => $cant * $product['price']
            ]);
        }

        for($i = 0; $i < 1000; $i++) {
            $product = Product::get()->random(1)[0];
            $cant = $faker->numberBetween(1, 1000);
            OrderProduct::create(
                [
                    'id_order' => Order::get()->random(1)[0]['id_order'],
                    'sku' => $product['sku'],
                    'price' => $product['price'],
                    'cant' => $cant,
                    'task' => 0.0,
                    'discount' => 0.0,
                    'total' => $cant * $product['price']
            ]);
        }

    }
}
