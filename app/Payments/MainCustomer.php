<?php

namespace App\Payments;

class MainCustomer implements \JsonSerializable
{

    private $name;

    private $email;

    private $birthDate;

    private $identity;

    private $identityType;

    private $address;

    private $deliveryAddress;

    public function __construct($data = null)
    {
        $this->name = isset($data['Name']) ? $data['Name'] : null;
        $this->email = isset($data['Email']) ? $data['Email'] : null;
        $this->birthDate = isset($data['Birthdate']) ? $data['Birthdate'] : null;

        $this->identity = isset($data['Identity']) ? $data['Identity'] : null;
        $this->identityType = isset($data['IdentityType']) ? $data-['IdentityType'] : null;

        if (isset($data['Address'])) {
            $this->address = new MainAddress($data['Address']);
        }

        if (isset($data['DeliveryAddress'])) {
            $this->deliveryAddress = new MainAddress($data['DeliveryAddress']);
        }
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate($data)
    {
        $this->name = isset($data->Name) ? $data->Name : null;
        $this->email = isset($data->Email) ? $data->Email : null;
        $this->birthDate = isset($data->Birthdate) ? $data->Birthdate : null;

        $this->identity = isset($data->Identity) ? $data->Identity : null;
        $this->identityType = isset($data->IdentityType) ? $data->IdentityType : null;

        if (isset($data->Address)) {
            $this->address = new MainAddress();
            $this->address->populate($data->Address);
        }

        if (isset($data->DeliveryAddress)) {
            $this->deliveryAddress = new MainAddress();
            $this->deliveryAddress->populate($data->DeliveryAddress);
        }
    }

    public function address($data)
    {
        $address = new MainAddress($data);

        $this->setAddress($address);

        return $address;
    }

    public function deliveryAddress($data)
    {
        $address = new MainAddress($data);

        $this->setDeliveryAddress($address);

        return $address;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    public function getIdentityType()
    {
        return $this->identityType;
    }

    public function setIdentityType($identityType)
    {
        $this->identityType = $identityType;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress($deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }
}
