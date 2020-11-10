<?php

namespace App\Payments\Azul;

use App\Payments\MainEnvironment;

class Environment extends MainEnvironment
{

    private function __construct($api, $apiQuery, $merchantId, $merchantKey, $apiBack=null)
    {
        parent::__construct($api, $apiQuery, $merchantId, $merchantKey, $apiBack);
    }

    public static function sandbox($data)
    {
        $api = 'https://pruebas.azul.com.do/webservices/JSON/Default.aspx';
        $apiQuery = 'https://pruebas.azul.com.do/webservices/JSON/Default.aspx';

        return new Environment($api, $apiQuery, $data['merchantId'], $data['merchantKey']);
    }

    public static function production($data)
    {
        $api = 'https://pagos.azul.com.do/webservices/JSON/Default.aspx';
        $apiQuery = 'https://pagos.azul.com.do/webservices/JSON/Default.aspx';

        $apiBack = 'https://contpagos.azul.com.do/Webservices/JSON/default.aspx';
        return new Environment($api, $apiQuery, $data['merchantId'], $data['merchantKey'], $apiBack);
    }
    
}
