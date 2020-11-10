<?php

namespace App\Clients;

abstract class MainEnvironment
{
    private $api;

    private $apiQuery;

    private $data;

    public function __construct($api, $apiQuery, $data)
    {
        $this->api = $api;
        $this->apiQuery = $apiQuery;
        $this->data = $data;
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


    /**
     * Gets the environment's token
     *
     * @return the token
     */
    public final function getSessionToken()
    {
        return $this->data['token'];
    }
}
