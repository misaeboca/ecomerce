<?php

namespace Seeds\Lanlimp;

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
                'username' => 'lanlimp',
                'email' => 'test@lanlimp.com',
                'password' => hash(env('ENCRYPTION_ALGORITHM'), 'hklj37j$h4'),
                'code' => generateUniqueId()
            ],
        ];

        User::insert($user);
    }

}
