<?php

namespace Seeds\General;

use App\Models\Admin\RolUser;
use Illuminate\Database\Seeder;

class RolesUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'user_id' => 1,
                'rol_id' => 1
            ],
            [
                'user_id' => 2,
                'rol_id' => 2
            ],
            [
                'user_id' => 3,
                'rol_id' => 3
            ],
            [
                'user_id' => 4,
                'rol_id' => 4
            ]
        ];

        RolUser::insert($roles);
    }

}
