<?php

namespace App\Deliveries\Ups;

use App\Deliveries\MainEnvironment;

class Environment extends MainEnvironment
{

    private function __construct($api, $apiQuery, $clientId, $secrectKey)
    {
        parent::__construct($api, $apiQuery, $clientId, $secrectKey);
    }

    public static function sandbox($clientId, $secrectKey = null)
    {
        $api = 'https://wwwcie.ups.com/ship/v1607/freight/shipments/';
        return new Environment($api, $apiQuery, $clientId, $secrectKey);
    }

    public static function production($clientId, $secrectKey = null)
    {
        $api = 'https://onlinetools.ups.com/ship/v1607/freight/shipments/';
        return new Environment($api, $apiQuery, $clientId, $secrectKey);
    }

}
