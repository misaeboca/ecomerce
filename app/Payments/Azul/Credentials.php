<?php

namespace App\Payments\Azul;

class Credentials implements \JsonSerializable
{

    private $auth1;
    private $auth2;

    public function __construct($data = null)
    {
   
        $this->auth1 = isset($data['Auth1'])? $data['Auth1']: null;
        $this->auth2 = isset($data['Auth2'])? $data['Auth2']: null;
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate($data = null)
    {
   
        $this->auth1 = isset($data->Auth1)? $data->Auth1: null;
        $this->auth2 = isset($data->Auth2)? $data->Auth2: null;
    }

    public  function getAuth1()
    {
        return $this->auth1;
    }

    public  function setAuth1($auth1)
    {
        $this->auth1 = $auth1;
        return $this;
    }

    public  function getAuth2()
    {
        return $this->auth2;
    }

    public  function setAuth2($auth2)
    {
        $this->auth2 = $auth2;
        return $this;
    }
}
