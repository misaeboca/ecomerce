<?php

namespace Seeds\General;

use App\Models\Admin\Delivery;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DeliveryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Delivery::create(
            [
            'name' => 'Loggi',
            'id' => 'loggi',
            'slug' => 'loggi'
        ]);
    }
}
