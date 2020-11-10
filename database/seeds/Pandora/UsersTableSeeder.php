<?php

namespace Seeds\Pandora;

use App\Models\Admin\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'username' => 'pandora',
                'email' => 'test@pandora.com',
                'password' => hash(env('ENCRYPTION_ALGORITHM'), 'pandora$h4'),
                'code' => generateUniqueId()
            ],
        ];

        User::insert($user);
    }

}
