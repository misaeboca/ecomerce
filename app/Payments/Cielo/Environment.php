<?php

namespace App\Payments\Cielo;

use App\Payments\MainEnvironment;

class Environment extends MainEnvironment
{

    private function __construct($api, $apiQuery, $merchantId, $merchantKey)
    {
        parent::__construct($api, $apiQuery, $merchantId, $merchantKey);
    }

    public static function sandbox($data)
    {
        $api = 'https://apisandbox.cieloecommerce.cielo.com.br/';
        $apiQuery = 'https://apiquerysandbox.cieloecommerce.cielo.com.br/';
        return new Environment($api, $apiQuery, $data['merchantId'], $data['merchantKey']);
    }

    public static function production($data)
    {
        $api = 'https://api.cieloecommerce.cielo.com.br/';
        $apiQuery = 'https://apiquery.cieloecommerce.cielo.com.br/';
        return new Environment($api, $apiQuery, $data['merchantId'], $data['merchantKey']);
    }

}
