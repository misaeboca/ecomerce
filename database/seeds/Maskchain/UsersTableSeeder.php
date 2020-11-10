<?php

namespace Seeds\Maskchain;

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
                'username' => 'Maskchain',
                'email' => 'test@maskchain.com',
                'password' => hash(env('ENCRYPTION_ALGORITHM'), 'm4skh41n'),
                'code' => generateUniqueId()
            ],
        ];

        User::insert($user);
    }

}
