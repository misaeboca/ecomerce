<?php

namespace App\Payments\Paypal;

use App\Payments\MainEnvironment;

class Environment extends MainEnvironment
{

    private function __construct($api, $apiQuery, $merchantId, $merchantKey)
    {
        parent::__construct($api, $apiQuery, $merchantId, $merchantKey);
    }

    public static function sandbox()
    {
        $api = 'https://apisandbox.braspag.com.br/';
        $apiQuery = 'https://apiquerysandbox.braspag.com.br/';
        $merchantId = env('BRASPAG_SANDBOX_MERCHANT_ID');
        $merchantKey = env('BRASPAG_SANDBOX_MERCHANT_KEY');
        return new Environment($api, $apiQuery, $merchantId, $merchantKey);
    }

    public static function production()
    {
        $api = 'https://api.braspag.com.br/';
        $apiQuery = 'https://apiquery.braspag.com.br/';
        $merchantId = env('BRASPAG_PROD_MERCHANT_ID');
        $merchantKey = env('BRASPAG_PROD_MERCHANT_KEY');

        return new Environment($api, $apiQuery, $merchantId, $merchantKey);
    }

}
