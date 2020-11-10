<?php

namespace Seeds\General;

use App\Models\Admin\ShareType;
use Illuminate\Database\Seeder;

class ShareTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shareTypes = [
            [
                'name' => 'whatsapp',
                'id' => 'sharewhatsapp'
            ],
            [
                'name' => 'facebook',
                'id' => 'sharefacebook'
            ],
            [
                'name' => 'youtube',
                'id' => 'shareyoutube'
            ],
            [
                'name' => 'instagram',
                'id' => 'shareinstagram'
            ],
            [
                'name' => 'twitter',
                'id' => 'shareteitter'
            ],
        ];

        ShareType::insert($shareTypes);

    }
}
