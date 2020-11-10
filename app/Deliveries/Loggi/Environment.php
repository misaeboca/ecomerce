<?php

namespace App\Deliveries\Loggi;

use App\Deliveries\MainEnvironment;

class Environment extends MainEnvironment
{

    private function __construct($api, $apiQuery, $clientId, $secrectKey)
    {
        parent::__construct($api, $apiQuery, $clientId, $secrectKey);
    }

    public static function sandbox($clientId, $secrectKey = null)
    {
        $api = 'https://staging.loggi.com/graphql/';
        $apiQuery = 'https://staging.loggi.com/graphql';
        return new Environment($api, $apiQuery, $clientId, $secrectKey);
    }

    public static function production($clientId, $secrectKey = null)
    {
        $api = 'https://loggi.com/graphql';
        $apiQuery = 'https://loggi.com/graphql';
        return new Environment($api, $apiQuery, $clientId, $secrectKey);
    }

}
