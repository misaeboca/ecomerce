<?php

namespace App\Payments\Braspag;

use App\Payments\Interfaces\IPaymentMethod;
use App\Payments\MainPaymentMethod;
use GuzzleHttp\Client;
use Exception;

use function GuzzleHttp\json_decode;

class Braspag implements IPaymentMethod
{
    //APIOOC URL https://braspag.github.io//en/manual/braspag-pagador?json#request
    /*

    {
        "MerchantOrderId":"2017051002",
        "Customer":{
            "Name":"Shopper Name",
            "Identity":"12345678909",
            "IdentityType":"CPF",
            "Email": "shopper@braspag.com.br",
            "Birthdate":"1991-01-02",
            "Address":{
                "Street":"Alameda Xingu",
                "Number":"512",
                "Complement":"27th floor",
                "ZipCode":"12345987",
                "City":"São Paulo",
                "State":"SP",
                "Country":"BRA",
                "District":"Alphaville"
            },
            "DeliveryAddress":{
                "Street":"Alameda Xingu",
                "Number":"512",
                "Complement":"27th floor",
                "ZipCode":"12345987",
                "City":"São Paulo",
                "State":"SP",
                "Country":"BRA",
                "District":"Alphaville"
            }
        },
        "Payment":{
            "Provider":"Simulado",
            "Type":"CreditCard",
            "Amount":10000,
            "Currency":"BRL",
            "Country":"BRA",
            "Installments":1,
            "Interest":"ByMerchant",
            "Capture":true,
            "Authenticate":false,
            "Recurrent":false,
            "SoftDescriptor":"Message",
            "DoSplit":false,
            "CreditCard":{
                "CardNumber":"4551870000000181",
                "Holder": "Cardholder Name",
                "ExpirationDate":"12/2021",
                "SecurityCode":"123",
                "Brand":"Visa",
                "SaveCard":"false",
                "Alias":"",
                "CardOnFile":{
                    "Usage": "Used",
                    "Reason":"Unscheduled"
                }
            },
            "Credentials":{
                "code":"9999999",
                "key":"D8888888",
                "password":"LOJA9999999",
                "username":"#Braspag2018@NOMEDALOJA#",
                "signature":"001"
            },
            "ExtraDataCollection":[
                {
                    "Name":"FieldName",
                    "Value":"FieldValue"
                }
            ]
        }
    }
    */

    private $environment;

    private $sale;

    private $credentials;

    private $statusCode;

    private $response;

    public function __construct($merchant_id, $merchant_key)
    {
        switch(env('BRASPAG_ENVIRONMENT_MODE')) {
            case 'sandbox':
                $this->environment = Environment::sandbox(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
            break;

            case 'production':
                $this->environment = Environment::production(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
            break;

            default:
                logError('braspag no mode selected');
                $this->environment = Environment::sandbox(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
                throw new Exception('braspag no mode selected');
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
        ->creditCard($data['securityCode'], $data['brand'])
        ->setExpirationDate($data['expirationDate'])
        ->setCardNumber($data['cardNumber'])
        ->setHolder($data['holder']);
        return $this;
    }

    public function setDebitCard($data) {
        $this->sale
        ->getPayment()
        ->setType(Payment::PAYMENTTYPE_DEBITCARD)
        ->creditCard($data['securityCode'], $data['brand'])
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
        return MainPaymentMethod::GATEWAY_BRASPAG;
    }

    public function setCredentials($data)
    {
        /*
            "Code" => "9999999",
            "Key" =>  "D8888888",
            "Password" => "LOJA9999999",
            "Username" => "#Braspag2018@NOMEDALOJA#",
            "Signature" => "001"
        */
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

        $response = $client->post($this->environment->getApiUrl() . 'v2/sales/',
            ['body' => $this->getBody()]
        );

        if($response->getStatusCode() == 201)
        {
            $this->statusCode = 200;
            $body = json_decode($response->getBody());

            if(($body->Payment->ReasonCode == 0) && ($body->Payment->ReasonMessage === "Successful") && ($body->Payment->ProviderReturnCode == 4)) {
                $this->response = [
                    'payment_response' => json_encode($body),
                    'payment_response_process' => json_encode([
                        'authorizationCode' => $body->Payment->AuthorizationCode,
                        'cardNumber'  => substr($body->Payment->CreditCard->CardNumber, -4),
                        'proofOfSale' => $body->Payment->ProofOfSale,
                        'paymentId' => $body->Payment->PaymentId,
                        'installments' => $body->Payment->Installments
                    ]),
                    'ReasonCode' => $body->Payment->ReasonCode,
                    'ReturnMessage' => $body->Payment->ReasonMessage,
                    'ProviderReturnCode' => $body->Payment->ProviderReturnCode,
                ];
            }
            else {
                $this->statusCode = 400;
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
        $payment_response_process = json_decode($data['payment_response_process']);

        $client = new Client([
            'headers' => $this->getHeaders()
        ]);

        try {

            $response = $client->put($this->environment->getApiUrl() . 'v2/sales/' . $payment_response_process->paymentId . '/void?amount='. $data['total'], [
                'request.options' => array(
                    'exceptions' => false,
                  )
            ]);
            $body = json_decode($response->getBody());

            if($response->getStatusCode() == 200)
            {
                $this->statusCode = 200;
 
                if(($body->ReasonCode == 0) && ($body->ReasonMessage === "Successful") && ($body->ProviderReturnCode == 4)) {
                    $this->response = [
                        'refund_response' => $body,
                        'refund_response_process' => json_encode([
                            ''
                        ]),
                        'ReasonCode' => $body->ReasonCode,
                        'ReturnMessage' => $body->ReasonMessage,
                        'ProviderReturnCode' => $body->ProviderReturnCode
                
                    ];
                }

            }
        } catch (\Exception $e)
        {
            $this->statusCode = 309;
            $this->response = [
                'refund_response' => $e->getMessage(),
                'ReasonCode' => -1,
                'ReturnMessage' => 'Transaction not available to void'
            ];
        }

    }
}
