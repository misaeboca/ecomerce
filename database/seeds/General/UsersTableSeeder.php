<?php

namespace Seeds\General;

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
                'username' => 'root',
                'email' => 'root@ecommerce.com',
                'password' => hash(env('ENCRYPTION_ALGORITHM'), 'root12345678'),
                'code' => generateUniqueId()
            ],
            [
                'username' => 'master_store',
                'email' => 'masterstore@ecommerce.com',
                'password' => hash(env('ENCRYPTION_ALGORITHM'), 'master12345678'),
                'code' => generateUniqueId()
            ],
            [
                'username' => 'master_franchise',
                'email' => 'masterfranchise@ecommerce.com',
                'password' => hash(env('ENCRYPTION_ALGORITHM'), 'franchise12345678'),
                'code' => generateUniqueId()
            ],

        ];

        User::insert($user);
    }

}
