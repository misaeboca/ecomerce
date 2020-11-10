<?php

namespace App\Clients\Pandora;

use App\Clients\MainEnvironment;

class Environment extends MainEnvironment
{

    private function __construct($api, $apiQuery, $data)
    {
        parent::__construct($api, $apiQuery, $data);
    }

    public static function sandbox($data)
    {
        $api = 'http://54.237.51.171/api/';
        $apiQuery = 'http://54.237.51.171/api/';
        return new Environment($api, $apiQuery, $data);
    }

    public static function production($data)
    {
        $api = 'http://54.237.51.171/api/';
        $apiQuery = 'http://54.237.51.171/api/';
        return new Environment($api, $apiQuery, $data);
    }

}
