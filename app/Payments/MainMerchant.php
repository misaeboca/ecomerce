<?php

namespace App\Payments;

class MainMerchant
{
    private $id;
    private $key;

    public function __construct($id, $key)
    {
        $this->id = $id;
        $this->key = $key;
    }

    /**
     * Gets the merchant identification number
     *
     * @return the merchant identification number on payment gateway
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the merchant identification key
     *
     * @return the merchant identification key on payment gateway
     */
    public function getKey()
    {
        return $this->key;
    }
}
