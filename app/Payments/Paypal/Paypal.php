<?php

namespace App\Payments\Paypal;

use App\Payments\Interfaces\IPaymentMethod;
use Exception;

class Paypal implements IPaymentMethod
{

    //APIOOC URL

    private $environment;

    private $sale;

    private $credentials;

    public function __construct()
    {
        switch(env('PAYPAL_ENVIRONMENT_MODE')) {
            case 'sandbox':
                $this->environment = Environment::sandbox();
            break;

            case 'production':
                $this->environment = Environment::production();
            break;

            default:
                logError('paypal no mode selected');
                $this->environment = Environment::sandbox();
                throw new Exception('paypal no mode selected');
            break;
        }

    }

    public function getUrlConnection() {
        return $this->environment->getApiUrl() . 'v2/sales/';
    }

    public function setOrder($orderId) {
        return $this;
    }

    public function getOrder()
    {
        return $this->sale->getMerchantOrderId();
    }

    public function setCustomer($data) {
        return $this;
    }

    public function setCustomerAddress($data) {
        return $this;
    }

    public function setCustomerDeliveryAddress($data) {
        return $this;
    }

    public function setPayment($data) {
        return $this;
    }

    public function setCreditCard($data) {
        return $this;
    }

    public function setDebitCard($data) {
        return $this;
    }

    public function getHeaders() {
        $data = [
            'Content-Type' => 'application/json',
            'MerchantId' => $this->environment->getMerchantId(),
            'MerchantKey' => $this->environment->getMerchantKey(),
        ];
        return $data;
    }

    public function getBody() {

    }

    public function getCredentials() {
        return $this->credentials;
    }

}
