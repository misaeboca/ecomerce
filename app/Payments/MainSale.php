<?php

namespace App\Payments;

class MainSale implements \JsonSerializable
{

    private $merchantOrderId;

    private $customer;

    private $payment;

    public function __construct($merchantOrderId = null)
    {
        $this->setMerchantOrderId($merchantOrderId);
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate(\stdClass $data)
    {
        $dataProps = get_object_vars($data);
        if (isset($dataProps['Customer'])) {
            $this->customer = new MainCustomer();
            $this->customer->populate($data->Customer);
        }

        if (isset($dataProps['Payment'])) {
            $this->payment = new MainPayment();
            $this->payment->populate($data->Payment);
        }

        if (isset($dataProps['MerchantOrderId'])) {
            $this->merchantOrderId = $data->MerchantOrderId;
        }
    }

    public static function fromJson($json)
    {
        $object = json_decode($json);

        $sale = new MainSale();
        $sale->populate($object);

        return $sale;
    }

    public function customer($data)
    {
        $this->customer = new MainCustomer($data);
    }

    public function customerAddress($data)
    {
        $this->customer->address($data);
    }

    public function customerDeliveryAddress($data)
    {
        $this->customer->deliveryAddress($data);
    }

    public function payment($data)
    {
        $this->payment = new MainPayment($data);
    }

    public function getMerchantOrderId()
    {
        return $this->merchantOrderId;
    }

    public function setMerchantOrderId($merchantOrderId)
    {
        $this->merchantOrderId = $merchantOrderId;
        return $this;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer(MainCustomer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    public function getPayment()
    {
        return $this->payment;
    }

    public function setPayment(MainPayment $payment)
    {
        $this->payment = $payment;
        return $this;
    }

    public function setInstallments($installments)
    {
        $this->payment->setInstallments($installments);
        return $this;
    }

    public function setInterest($interest)
    {
        $this->payment->setInterest($interest);
        return $this;
    }

}
