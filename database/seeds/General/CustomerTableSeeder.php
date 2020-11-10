<?php

namespace Seeds\General;

use App\Models\Admin\Customer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerTableSeeder extends Seeder
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
            Customer::create(
                [
                    'id' => generateUniqueId(),
                    'name' => $faker->name,
                    'lastname' => $faker->lastName,
                    'email' => $faker->email
            ]);
        }

    }
}
