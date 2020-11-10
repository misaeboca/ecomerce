<?php

namespace Seeds\Pandora;

use App\Models\Admin\Material;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 10; $i++) {
            $name = $faker->name;
            Material::create(
                [
                    'id' => generateUniqueId(),
                    'name' => $name,
                    'slug' => generateSlug($name)
            ]);
        }

    }
}
