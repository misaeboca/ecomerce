<?php

namespace App\Payments;

abstract class MainEnvironment
{
    private $api;

    private $apiQuery;

    private $merchantId;

    private $merchantKey;

    public function __construct($api, $apiQuery, $merchantId, $merchantKey)
    {
        $this->api = $api;
        $this->apiQuery = $apiQuery;
        $this->merchantId = $merchantId;
        $this->merchantKey = $merchantKey;
    }

    public abstract static function sandbox($data);

    public abstract static function production($data);


    /**
     * Gets the environment's Api URL
     *
     * @return the Api URL
     */
    public final function getApiUrl()
    {
        return $this->api;
    }

    /**
     * Gets the environment's Api Query URL
     *
     * @return the Api Query URL
     */
    public final function getApiQueryURL()
    {
        return $this->apiQuery;
    }

        /**
     * Gets the environment's merchant Id
     *
     * @return the merchantId
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

        /**
     * Gets the environment's merchant Key
     *
     * @return the merchantKey
     */
    public final function getMerchantKey()
    {
        return $this->merchantKey;
    }

}
