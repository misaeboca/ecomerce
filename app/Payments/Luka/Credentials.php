<?php

namespace App\Payments\Luka;

class Credentials implements \JsonSerializable
{
    private $username;

    private $password;

    private $authType;

    public function __construct($data = null)
    {

        $this->username = isset($data['Username'])? $data['Username']: null;
        $this->password = isset($data['Password'])? $data['Password']: null;

        $this->authType = 'password';
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate($data = null)
    {
        $this->username = isset($data->Username)? $data->Username: null;
        $this->password = isset($data->Password)? $data->Password: null;
        $this->authType = 'password';
    }

    public function getauthType()
    {
        return $this->code;
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

}
