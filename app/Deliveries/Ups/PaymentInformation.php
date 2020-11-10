<?php

namespace App\Deliveries\Ups;

class PaymentInformation implements \JsonSerializable
{

    private $payer;
    private $ShipmentBillingOption;


    public function __construct($data = null)
    {
        if (isset($data['Payer'])) {
            $this->address = new Payer($data['Payer']);
        }

        if (isset($data['ShipmentBillingOption'])) {
            $this->address = new ShipmentBillingOption($data['ShipmentBillingOption']);
        }
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate($data)
    {

        if (isset($data->payer)) {
            $this->payer = new Payer();
            $this->payer->populate($data->payer);
        }

        if (isset($data->ShipmentBillingOption)) {
            $this->ShipmentBillingOption = new ShipmentBillingOption();
            $this->ShipmentBillingOption->populate($data->ShipmentBillingOption);
        }
    }

    public function payer($data)
    {
        $payer = new Payer($data);
        $this->setPayer($payer);

        return $payer;
    }

    public function ShipmentBillingOption($data)
    {
        $ShipmentBillingOption = new ShipmentBillingOption($data);
        $this->setShipmentBillingOption($ShipmentBillingOption);

        return $ShipmentBillingOption;
    }


    public function getPayer()
    {
        return $this->payer;
    }

    public function setPayer($payer)
    {
        $this->payer = $payer;
        return $this;
    }

    public function getShipmentBillingOption()
    {
        return $this->ShipmentBillingOption;
    }

    public function setShipmentBillingOption($ShipmentBillingOption)
    {
        $this->ShipmentBillingOption = $ShipmentBillingOption;
        return $this;
    }

}
