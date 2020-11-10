<?php
namespace App\Payments\Azul;

use App\Payments\Interfaces\IPaymentMethod;
use App\Payments\MainPaymentMethod;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Carbon;

class Azul implements IPaymentMethod
{
    // URL https://contpagos.azul.com.do/Webservices/JSON/default.aspx

    private $environment;
    private $sale;
    private $credentials;
    private $store;
    private $statusCode;
    private $response;

    public function __construct($merchant_id, $merchant_key)
    {
        switch(env('AZUL_ENVIRONMENT_MODE')) {
            case 'sandbox':
                $this->environment = Environment::sandbox(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
            break;

            case 'production':
                $this->environment = Environment::production(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
            break;

            default:
                logError('azul no mode selected');
                $this->environment = Environment::sandbox(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
                throw new Exception('azul no mode selected');
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
        $this->sale->customer($data);
        return $this;
    }

    public function setCustomerAddress($data) {
        $this->sale->customerAddress($data);
        return $this;
    }

    public function setCustomerDeliveryAddress($data) {
        $this->sale->customerDeliveryAddress($data);
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


    public function setStore($data)
    {
        $this->store = new Store($data);
    }

    public function getStore()
    {
        return $this->store;
    }
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getPaymentName()
    {
        return MainPaymentMethod::GATEWAY_AZUL;
    }

    public function setCredentials($data)
    {
        /*
            "auth1" => "xxxxx",
            "auth2" => "yyyyy"
        */
        $this->credentials = new Credentials($data);
        return $this;
    }

    public function getCredentials() {
        return $this->credentials;
    }

    public function getHeaders() {

        $data = [
            'Content-Type' => 'application/json',
            'Auth1' => $this->credentials->getAuth1(),
            'Auth2' => $this->credentials->getAuth2()
        ];
        return $data;
    }

    public function getBody() {

         $exp = explode("/",$this->sale->getPayment()->getCreditCard()->getExpirationDate());
         $fecha  =  $exp[1].$exp[0];

         $data = [
            "Channel"       => "EC",
            "Store"         => "05",
            "CardNumber"    => $this->sale->getPayment()->getCreditCard()->getCardNumber(),
            "Expiration"    => $fecha,
            "CVC"           => $this->sale->getPayment()->getCreditCard()->getSecurityCode(),
            "PosInputMode"  => "E-Commerce",
            "TrxType"   => "Sale",
            "Amount"    => $this->sale->getPayment()->getAmount(),
            "Itbis"     => $this->sale->getPayment()->getItbis(),
            "CurrencyPosCode" =>  $this->sale->getPayment()->getCurrency(),
            "Payments" => "1",
            "Plan" => "0",
            "AcquirerRefData" => "1",
            "OrderNumber" => $this->getOrder(),
        ];
        return json_encode($data);
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

        $response = $client->post($this->environment->getApiUrl(),
            ['body' => $this->getBody()]
        );
    

        if($response->getStatusCode() == 201)
        {
            $this->statusCode = 200;
            $body = json_decode($response->getBody());

            if($body->AuthorizationCode !="" or $body->AuthorizationCode != NULL) {
                $this->response = [
                    'payment_response' => json_encode($body),
                    'payment_response_process' => json_encode([
                        'authorizationCode' => $body->AuthorizationCode,
                        'cardNumber'  => substr($body->CardNumber, -4),
                        'proofOfSale' => "",
                        'paymentId' => $body->RRN,
                        'installments' => 1,
                        "Amount"        => $this->getBody()["amount"],
                        "Itbis"         => $this->getBody()["Itbis"],
                        "CurrencyPosCode" => $this->getBody()["CurrencyPosCode"]
                    ]),
                    'ReasonCode' => $body->AuthorizationCode,
                    'ReturnMessage' => $body->ResponseMessage,
                    'ProviderReturnCode' => $body->Ticket,
                ];
            
            }else if($body->AuthorizationCode !="" or $body->AuthorizationCode != NULL){

                if($body->ResponseMessage == "DENEGADA"){
                    $message = "DENEGADA";
                }else{
                    $message = "PROVEEDOR INVALIDO";
                }

                $this->response = [
                    'payment_response' => json_encode($body),
                    'ReasonCode' => -1,
                    'ReturnMessage' => $message,
                    'ProviderReturnCode' => $body->Ticket,
                    "AuthorizationCode" =>  $body->AuthorizationCode,
                    "CustomOrderId"     =>  $body->CustomOrderId,
                    "DateTime"          =>  $body->DateTime,
                    "ErrorDescription"  =>  $body->ErrorDescription,
                    "RRN"               =>  $body->RRN
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

        $data_request = [
                    "Channel"           => "EC",
                    "Store"             => "05",
                    "CardNumber"    => $payment_response_process->cardNumber,
                    "Expiration"    => null,
                    "PosInputMode"  => "E-Commerce",
                    "TrxType"       => "Refund",
                    "Amount"        => $payment_response_process->amount,
                    "Itbis"         => $payment_response_process->Itbis,
                    "CurrencyPosCode" => $payment_response_process->CurrencyPosCode,
                    "Payments"        => "1",
                    "Plan"            => "0",
                    "OriginalDate"    => $payment_response_process->DateTime,
                    "CVC"             => null,
                    "RRN"             => null,
                    "AzulOrderId"     => $payment_response_process->AzulOrderId
        ];

        try {

            $response = $client->post($this->environment->getApiUrl(), [
                $data_request
            ]);
            $body = json_decode($response->getBody());

            if($response->getStatusCode() == 200)
            {
                $this->statusCode = 200;
 
                if(empty($body->AuthorizationCode)  && ($body->AuthorizationCode !== "" or $body->AuthorizationCode !== null)) {

                    $this->response = [
                        'refund_response' => $body,
                        'refund_response_process' => json_encode([
                            'authorizationCode' => $body->AuthorizationCode,
                            'AzulOrderId' => $body->AzulOrderId,
                            'RRN' => $body->RRN,
                            'DateTime' => $body->DateTime

                        ]),
                        'ReasonCode' => $body->AuthorizationCode,
                        'ReturnMessage' => $body->ResponseMessage,
                        'ProviderReturnCode' => $body->Ticket,
                        'ResponseCode' => $body->ResponseCode
                    ];

                }else{

                    if($body->AuthorizationCode !="" or $body->AuthorizationCode != NULL){

                        $this->response = [
                            'payment_response' => json_encode($body),
                            'ReasonCode' => -1,
                            'ReturnMessage'     => $body->ResponseMessage,
                            'ProviderReturnCode'=> $body->Ticket,
                            "AuthorizationCode" => $body->AuthorizationCode,
                            "CustomOrderId"     => $body->CustomOrderId,
                            "DateTime"          => $body->DateTime,
                            "ErrorDescription"  => $body->ErrorDescription
                        ];
                    }

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
