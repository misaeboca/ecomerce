<?php

namespace App\Deliveries\Ups;

class Credentials 
{

    private $username;
    private $password;
    private $accessLicenseNumber;
    private $accountId;

    public function __construct($data = null)
    {
        $this->username = 'leonardo.chan';
        $this->password = 'Greetings.1';
        $this->accessLicenseNumber = '2D88E9E67E85B2B5';
        $this->accountId = '61WV51'; //ShopID
    }

    public  function getUsername()
    {
        return $this->username;
    }

    public  function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public  function getPassword()
    {
        return $this->password;
    }

    public  function setPassword($username)
    {
        $this->password = $password;
        return $this;
    }

    public  function getAccessLicenseNumber()
    {
        return $this->accessLicenseNumber;
    }

    public  function setAccessLicenseNumber($license)
    {
        $this->accessLicenseNumber = $accessLicenseNumber;
        return $this;
    }

    public  function getAccountID()
    {
        return $this->accountId;
    }

    public  function setAccountId($accountId)
    {
        $this->accountId = $accountId;
        return $this;
    }
}
