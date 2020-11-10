<?php

namespace Seeds\Frigidaire;

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
                'username' => 'frigidaire',
                'email' => 'test@frigidaire.com',
                'password' => hash(env('ENCRYPTION_ALGORITHM'), 'fr1g1d41r3'),
                'code' => generateUniqueId()
            ],
        ];

        User::insert($user);
    }

}
