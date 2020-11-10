<?php

namespace App\Payments\Cielo;

class Credentials implements \JsonSerializable
{

    private $code;

    private $key;

    private $username;

    private $password;

    private $signature;


    public function __construct($data = null)
    {
        $this->code = isset($data['Code'])? $data['Code']: null;
        $this->key = isset($data['Key'])? $data['Key']: null;
        $this->username = isset($data['Username'])? $data['Username']: null;
        $this->password = isset($data['Password'])? $data['Password']: null;
        $this->signature = isset($data['Signature'])? $data['Signature']: null;
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate($data = null)
    {
        $this->code = isset($data->Code)? $data->Code: null;
        $this->number = isset($data->Key)? $data->Key: null;
        $this->username = isset($data->Username)? $data->Username: null;
        $this->password = isset($data->Password)? $data->Password: null;
        $this->signature = isset($data->Signature)? $data->Signature: null;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setSignature($signature)
    {
        $this->signature = $signature;
        return $this;
    }

}
