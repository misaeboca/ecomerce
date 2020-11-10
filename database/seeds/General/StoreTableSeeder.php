<?php

namespace Seeds\General;

use App\Models\Admin\Store;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StoreTableSeeder extends Seeder
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
            Store::create(
                [
                'name' => $faker->name,
                'country' => $faker->country,
                'id_store' => generateUniqueId(),
                'email' => $faker->email,
                'whatsapp' => $faker->e164PhoneNumber,
                'logo' => $faker->imageUrl(640, 480),
                'domain' => $faker->domainName
            ]);
        }

    }
}
