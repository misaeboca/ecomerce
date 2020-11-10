<?php

namespace App\Payments\Cielo;

use App\Payments\Interfaces\IPaymentMethod;
use App\Payments\MainPaymentMethod;
use GuzzleHttp\Client;
use Exception;

class Cielo implements IPaymentMethod
{
    //APIOOC URL https://developercielo.github.io/manual/cielo-ecommerce

    private $environment;

    private $sale;

    private $credentials;

    private $response;

    public function __construct($merchant_id, $merchant_key)
    {
        switch(env('CIELO_ENVIRONMENT_MODE')) {
            case 'sandbox':
                $this->environment = Environment::sandbox(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
            break;

            case 'production':
                $this->environment = Environment::production(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
            break;

            default:
                logError('cielo no mode selected');
                $this->environment = Environment::sandbox(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
                throw new Exception('cielo no mode selected');
            break;
        }

    }

    public function setOrder($data) {
        $this->sale = new Sale($data['id']);
        return $this;
    }

    public function setInstallments($installments = 1)
    {
        $this->sale->setInstallments($installments);
        return $this;
    }

    public function setInterest($interest = null)
    {
        if(is_null($interest)) {
            $interest = 'ByMerchant';
        }

        $this->sale->setInterest($interest);
        return $this;
    }

    public function getOrder()
    {
        return $this->sale->getMerchantOrderId();
    }

    public function setCustomer($data) {
        $customer = [
            'Name' => $data['name'],
            'Email' => $data['email'],
        ];
        $this->sale->customer($customer);
        return $this;
    }

    public function setCustomerAddress($data) {
        $customerAddress = [
            "Street" => $data['street'],
            "Number" => $data['number'],
            "Complement" => $data['complement'],
            "ZipCode" => $data['cep'],
            "City" => $data['city'],
            "State" => $data['state'],
            "Country" => $data['country'],
            "District" => $data['district'],
        ];
        $this->sale->customerAddress($customerAddress);
        return $this;
    }

    public function setCustomerDeliveryAddress($data) {
        $customerDeliveryAddress = [
            "Street" => $data['street'],
            "Number" => $data['number'],
            "Complement" => $data['complement'],
            "ZipCode" => $data['cep'],
            "City" => $data['city'],
            "State" => $data['state'],
            "Country" => $data['country'],
            "District" => $data['district'],
        ];
        $this->sale->customerDeliveryAddress($customerDeliveryAddress);
        return $this;
    }

    public function setPayment($data) {
        $this->sale->payment($data);
        return $this;
    }

    public function setCreditCard($data) {
        $this->sale
        ->getPayment()
        ->setType(Payment::PAYMENTTYPE_CREDITCARD)
        ->creditCard("123", "Visa")
        ->setExpirationDate($data['expirationDate'])
        ->setCardNumber($data['cardNumber'])
        ->setHolder($data['holder']);
        return $this;
    }

    public function setDebitCard($data) {
        $this->sale
        ->getPayment()
        ->setType(Payment::PAYMENTTYPE_DEBITCARD)
        ->creditCard("123", "Visa")
        ->setExpirationDate($data['expirationDate'])
        ->setCardNumber($data['cardNumber'])
        ->setHolder($data['holder']);
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
        $data = [
            'MerchantOrderId' => $this->getOrder(),
            'Customer' => $this->sale->getCustomer(),
            'Payment' => $this->sale->getPayment(),
            'Credentials' => $this->getCredentials()
        ];
        return json_encode($data);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getPaymentName()
    {
        return MainPaymentMethod::GATEWAY_CIELO;
    }

    public function setCredentials($data)
    {
        $this->credentials = new Credentials($data);
        return $this;
    }

    public function getCredentials() {
        return $this->credentials;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function create()
    {
        $client = new Client([
            'headers' => $this->getHeaders()
        ]);

        $response = $client->post($this->environment->getApiUrl() . '1/sales/',
            ['body' => $this->getBody()]
        );

        if($response->getStatusCode() == 201)
        {
            $this->statusCode = 200;
            $body = json_decode($response->getBody());

            if(($body->Payment->Status == 1) && ($body->Payment->ReturnCode == 4)) {
                $this->response = [
                    'payment_response' => json_encode($body),
                    'payment_response_process' => json_encode([
                        'authorizationCode' => $body->Payment->AuthorizationCode,
                        'cardNumber'  => substr($body->Payment->CreditCard->CardNumber, -4),
                        'proofOfSale' => $body->Payment->ProofOfSale,
                        'paymentId' => $body->Payment->PaymentId,
                        'installments' => $body->Payment->Installments
                    ]),
                    'ReasonCode' => $body->Payment->ReturnCode,
                    'ReturnMessage' => $body->Payment->ReturnMessage,
                    'ProviderReturnCode' => $body->Payment->ReturnCode
                ];
            }
            else {
                $this->response = [
                    'payment_response' => json_encode($body),
                    'ReasonCode' => -1,
                    'ReturnMessage' => $body->Payment->ReturnMessage,
                    'ProviderReturnCode' => $body->Payment->ProviderReturnCode
                ];
            }
        }

    }

    public function refund($data)
    {

    }
}
