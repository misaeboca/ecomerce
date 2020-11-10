<?php

namespace Seeds\Pandora;

use App\Models\Admin\Theme;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ThemeTableSeeder extends Seeder
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
            Theme::create(
                [
                    'id' => generateUniqueId(),
                    'name' => $faker->name,
                    'slug' => generateSlug($name)
            ]);
        }

    }
}
