<?php

namespace Seeds\General;

use App\Models\Admin\Order;
use App\Models\Admin\Store;
use App\Models\Admin\Delivery;
use App\Models\Admin\Customer;
use App\Models\Admin\Payment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 300; $i++) {
            Order::create(
                [
                    'id_store' =>  Store::get()->random(1)[0]['id'],
                    'id_share' => Delivery::get()->random(1)[0]['id'],
                    'id_delivery' => Delivery::get()->random(1)[0]['id'],
                    'id_payment' => Payment::get()->random(1)[0]['id'],
                    'id_customer' => Customer::get()->random(1)[0]['id'],
                    'id_order' => generateUniqueId(),
                    'total' => $faker->randomFloat(NULL, 0, 9999999),
                    'status' => $faker->randomElements(array('approved','pending','reject'), 1)[0],
                    'observations' => $faker->text(200)
            ]);
        }

    }
}
