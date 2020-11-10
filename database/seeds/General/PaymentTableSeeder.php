<?php

namespace Seeds\General;

use App\Models\Admin\Payment;
use App\Payments\MainPaymentMethod;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        Payment::create(
            [
            'name' => 'Braspag',
            'id' => 'braspag',
            'slug' => MainPaymentMethod::GATEWAY_BRASPAG
            ]
        );

        Payment::create(
            [
            'name' => 'Cielo',
            'id' => 'cielo',
            'slug' => MainPaymentMethod::GATEWAY_CIELO
            ]
        );

        Payment::create(
            [
            'name' => 'Azul',
            'id' => 'azul',
            'slug' => MainPaymentMethod::GATEWAY_AZUL
            ]
        );

        Payment::create(
            [
            'name' => 'Luka',
            'id' => 'luka',
            'slug' => MainPaymentMethod::GATEWAY_LUKA
            ]
        );

    }
}
