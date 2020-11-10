<?php

namespace Seeds\General;

use App\Models\Admin\Customer;
use App\Models\Admin\Store;
use App\Models\Admin\StoreCustomer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StoreCustomerTableSeeder extends Seeder
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
            StoreCustomer::create(
                [
                    'id_customer' => Customer::get()->random(1)[0]['id_customer'],
                    'id_store' =>  Store::get()->random(1)[0]['id_store'],
            ]);
        }

    }
}
