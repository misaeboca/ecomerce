<?php

namespace App\Clients\Lanlimp;

use App\Clients\MainEnvironment;

class Environment extends MainEnvironment
{

    private function __construct($api, $apiQuery, $data)
    {
        parent::__construct($api, $apiQuery, $data);
    }

    public static function sandbox($data)
    {
        $api = 'https://portal.lanlimp.com.br/api/';
        $apiQuery = 'https://portal.lanlimp.com.br/api/';
        return new Environment($api, $apiQuery, $data);
    }

    public static function production($data)
    {
        $api = '';
        $apiQuery = '';
        return new Environment($api, $apiQuery, $data);
    }

}
