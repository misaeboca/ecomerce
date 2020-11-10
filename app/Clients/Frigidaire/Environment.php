<?php

namespace App\Clients\Frigidaire;

use App\Clients\MainEnvironment;

class Environment extends MainEnvironment
{

    private function __construct($api, $apiQuery, $data)
    {
        parent::__construct($api, $apiQuery, $data);
    }

    public static function sandbox($data)
    {
                
        $api = 'http://190.167.212.137:8089/application/api/v1/';
        $apiQuery = 'http://190.167.212.137:8089/application/api/v1/';
        return new Environment($api, $apiQuery, $data);
    }

    public static function production($data)
    {
        $api = 'http://190.167.212.137:8089/application/api/v1/';
        $apiQuery = 'http://190.167.212.137:8089/application/api/v1/';
        return new Environment($api, $apiQuery, $data);
    }

}
