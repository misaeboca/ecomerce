<?php

namespace App\Payments\Interfaces;

interface IPaymentMethod
{

    public function getOrder();

    public function getStatusCode();

    public function getPaymentName();

    public function setOrder($orderId);

    public function setCustomer($data);

    public function setCustomerAddress($data);

    public function setCustomerDeliveryAddress($data);

    public function setCredentials($data);

    public function setPayment($data);

    public function setCreditCard($data);

    public function setDebitCard($data);

    public function setInstallments($installments = 1);

    public function setInterest($interest = null);

    public function getResponse();

    public function create();

    public function refund($data);
}
