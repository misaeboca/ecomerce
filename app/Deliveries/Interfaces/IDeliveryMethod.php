<?php

namespace App\Deliveries\Interfaces;

interface IDeliveryMethod
{

    public function getQuotation($data);

    public function getDistance();

    public function isFree($data);

    public function notifyDelivery($data);

    public function trackingUrl($orderPk);
}
