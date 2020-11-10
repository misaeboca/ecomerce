<?php

use Illuminate\Database\Seeder;

class PandoraSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Seeds\General\DeliveryTableSeeder::class);
        $this->call(Seeds\General\PaymentTableSeeder::class);
        $this->call(Seeds\General\ShareTypeTableSeeder::class);
        $this->call(Seeds\General\RolesTableSeeder::class);
        $this->call(Seeds\General\UsersTableSeeder::class);
        $this->call(Seeds\Pandora\UsersTableSeeder::class);
        $this->call(Seeds\General\UsersProfileTableSeeder::class);
        $this->call(Seeds\General\RolesUserTableSeeder::class);
        $this->call(Seeds\Pandora\MaterialTableSeeder::class);
        $this->call(Seeds\Pandora\ThemeTableSeeder::class);
    }
}