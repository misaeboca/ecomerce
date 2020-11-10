<?php
namespace App\Payments\Luka;

use App\Payments\Interfaces\IPaymentMethod;
use App\Payments\MainPaymentMethod;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Carbon;

class Luka implements IPaymentMethod
{
    // URL https://contpagos.azul.com.do/Webservices/JSON/default.aspx
    private $environment;
    private $sale;
    private $credentials;
    private $statusCode;
    private $response;
    private $encryptor;
    private $slug;

    public function __construct($merchant_id, $merchant_key)
    {
        switch(env('LUKA_ENVIRONMENT_MODE')) {
            case 'sandbox':
                $this->environment = Environment::sandbox(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
            break;

            case 'production':
                $this->environment = Environment::production(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
            break;

            default:
                logError('luka no mode selected');
                $this->environment = Environment::sandbox(['merchantId' => $merchant_id, 'merchantKey' => $merchant_key]);
                throw new Exception('luka no mode selected');
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

    public function setCredentials($data)
    {
        /*
            "Password" => "yaluTech",
            "Username" => "Y@luTech20$",
            "authType" => "password"
        */
        $this->credentials = new Credentials($data);
        return $this;
    }

    public function getCredentials() {
        return $this->credentials;
    }

    public function setSlug($data)
    {
        /*
            CountryPayment
        */
        $this->slug = new CountryPayment($data);
        return $this;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setEncryptor() {
        $this->encryptor = new Encryptor();
    }

    public function getEncryptor() {
        return $this->encryptor;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getPaymentName()
    {
        return MainPaymentMethod::GATEWAY_LUKA;
    }

    public function getHeaders( ) {
        $token = $this->getToken();
        $date = new Carbon();

        $date_expiration = Carbon::now($token["date_expiration"]);

        if(!$date_expiration->lte($date)){
            $token = $this->getToken();
        }

        $iv = $this->encryptor::iv();
        
        $data = [
            'Content-Type' => 'application/json',
            'access-token' => $token["token"],
            'raw-iv' => $iv;
        ];
        return $data;
    }

    public function getBody() {

        $iv = $this->getHeaders()["raw-iv"];
        $carInfo = [
            "cardNumber"    => $this->sale->getPayment()->getCreditCard()->getCardNumber(),
            "expDate"    => $this->sale->getPayment()->getCreditCard()->getExpirationDate(),
            "cvv2"           => $this->sale->getPayment()->getCreditCard()->getSecurityCode()
        ];

        $json_card = json_encode($carInfo);
        $carInfoEncrip = $this->encryptor::encrypt($json_card, $iv);

          $data = [
            'MerchantOrderId' => $this->getOrder(),
            "cardInfo"      => $carInfoEncrip;
            "amount"        => $this->sale->getPayment()->getAmount(),
            "channel"       => "web",
            "userId"        => $this->sale->getCustomer()->identity
        ];
        return json_encode($data);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getToken(){

        $response = Http::post($this->environment->getApiUrl(). $this->slug->getSlug().'/generateToken', [
                'username' => $this->credentials->getUsername(),
                'password' => $this->credentials->getPassword(),
                'authType' => $this->credentials->getauthType()
        ]);

        $data_token = [];

        if($response->status() == 200) {

            $json = $response->json();

            $date = Carbon::now();
            $date_expiration =  $date->addSeconds($json['expires_in']);

            $data_token["token"] = $json['token'];
            $data_token["expires_in"] = $json['expires_in'];
            $data_token["date_expiration"] = $date_expiration;

        }

        return  $data_token;
    }
    public function create()
    {
        $client = new Client([
            'headers' => $this->getHeaders()
        ]);

        $response = $client->post($this->environment->getApiUrl() .$this->slug->getSlug(). '/getHostedPage',
            ['body' => $this->getBody()]
        );

        if($response->getStatusCode() == 201)
        {
            $this->statusCode = 200;
            $body = json_decode($response->getBody());

            //transacion aprobada
            if($body->AuthorizeResult->CreditCardTransactionResults->ReasonCode == 1) {

                $tran_resp = $body->AuthorizeResult->CreditCardTransactionResults
                $this->response = [
                    'payment_response' => json_encode($body),
                    'payment_response_process' => json_encode([
                        'authorizationCode' =>  $tran_resp->AuthCode,
                        'cardNumber'  => substr($tran_resp->PaddedCardNumber, -4),
                        'proofOfSale' => "",
                        'paymentId' => $tran_resp->ReferenceNumber,
                        "ReasonCodeDescription" => $tran_resp->ReasonCodeDescription,
                        "Amount"        => $this->getBody()["amount"]
                    ]),
                    'ReasonCode' => $tran_resp->ReasonCode,
                    'ReturnMessage' => $tran_resp->ReasonCodeDescription,
                    'ProviderReturnCode' => $tran_resp->TokenizedPAN
                ];
                
            }else if($body->AuthorizeResult->CreditCardTransactionResults->ReasonCode == 2){

                $tran_resp = $body->AuthorizeResult->CreditCardTransactionResults;

                $this->response = [
                    'payment_response' => json_encode($body),
                    'ReasonCode' => -1,
                    'ReturnMessage' => $tran_resp->ReasonCodeDescription,
                    'ProviderReturnCode' =>$tran_resp->ResponseCode,
                    "OriginalResponseCode"      =>$tran_resp->OriginalResponseCode
                ];
            }
        }
    }

    public function refund($data)
    {

    }

}
