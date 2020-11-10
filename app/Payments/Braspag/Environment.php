<?php

namespace App\Payments\Braspag;

use App\Payments\MainEnvironment;


class Environment extends MainEnvironment
{
 
    private function __construct($api, $apiQuery, $merchantId, $merchantKey)
    {
        parent::__construct($api, $apiQuery, $merchantId, $merchantKey);
    }

    public static function sandbox($data)
    {
        $api = 'https://apisandbox.braspag.com.br/';
        $apiQuery = 'https://apiquerysandbox.braspag.com.br/';
        return new Environment($api, $apiQuery, $data['merchantId'], $data['merchantKey']);
    }

    public static function production($data)
    {
        $api = 'https://api.braspag.com.br/';
        $apiQuery = 'https://apiquery.braspag.com.br/';
        return new Environment($api, $apiQuery, $data['merchantId'], $data['merchantKey']);
    }

}
