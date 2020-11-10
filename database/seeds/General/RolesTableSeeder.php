<?php

namespace Seeds\General;

use App\Models\Admin\Rol;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
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
                'name' => 'root'
            ],
            [
                'name' => 'master'
            ],
            [
                'name' => 'master_franchise'
            ],
            [
                'name' => 'store'
            ],
            [
                'name' => 'user'
            ]
        ];

        Rol::insert($roles);
    }
}
