<?php

namespace App\Payments\Luka;

use App\Payments\MainEnvironment;

class Environment extends MainEnvironment
{
    
    private function __construct($api, $apiQuery, $merchantId, $merchantKey, $apiBack=null)
    {
        parent::__construct($api, $apiQuery, $merchantId, $merchantKey, $apiBack);
    }

    public static function sandbox($data)
    {
        $api = 'https://api-staging.luka.com.gt/api/';
        $apiQuery = 'https://api-staging.luka.com.gt/api/';

        return new Environment($api, $apiQuery, $data['merchantId'], $data['merchantKey'], $apiBack);
    }

    public static function production($data)
    {
        $api = 'https://api-staging.luka.com.gt/api/';

        $apiBack = 'https://api-staging.luka.com.gt/api/';
        return new Environment($api, $apiQuery, $data['merchantId'], $data['merchantKey'], $apiBack);
    }

}
