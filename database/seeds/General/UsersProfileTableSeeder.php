<?php

namespace Seeds\General;

use App\Models\Admin\User;
use App\Models\Admin\UserProfile;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $users = User::get();

        foreach($users as $user)
        {
            $userProfiles = [
                'id_user' => $user->slug,
                'name' => 'root',
                'lastName' => 'root',
                'birthday' => $faker->date('Y-m-d'),
                'description' => $faker->realText(500),
            ];

            UserProfile::create($userProfiles);
        }

    }
}
