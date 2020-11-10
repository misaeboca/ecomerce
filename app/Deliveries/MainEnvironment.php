<?php

namespace App\Deliveries;

abstract class MainEnvironment
{
    private $api;

    private $apiQuery;

    private $clientId;

    private $secrectKey;

    public function __construct($api, $apiQuery, $clientId, $secrectKey)
    {
        $this->api = $api;
        $this->apiQuery = $apiQuery;
        $this->clientId = $clientId;
        $this->secrectKey = $secrectKey;
    }

    public abstract static function sandbox($clientId, $secrectKey = null);

    public abstract static function production($clientId, $secrectKey = null);

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
     * Gets the environment's client Id
     *
     * @return the clientId
     */
    public function getClientId()
    {
        return $this->clientId;
    }

        /**
     * Gets the environment's secret Key
     *
     * @return the secrectKey
     */
    public final function getSecrectKey()
    {
        return $this->secrectKey;
    }

}
