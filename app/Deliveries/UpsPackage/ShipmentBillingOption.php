<?php

namespace App\Deliveries\Ups;

class ShipmentBillingOption implements \JsonSerializable
{

    private $code;

    public function __construct($data = null)
    {
        $this->code = isset($data['code']) ? $data['code'] : null;
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate($data)
    {
        $this->code = $data->code ? $data->code : null;
    }


    public function getCode()
    {
        return $this->code;
    }

    public function setCode($Code)
    {
        $this->code = $code;
        return $this;
    }

}
