<?php

namespace App\Deliveries\Ups;

class ShipTo implements \JsonSerializable
{

    private $name;
    private $address;
    private $AttentionName;
    private $phone;


    public function __construct($data = null)
    {
        $this->name = isset($data['Name']) ? $data['Name'] : null;
        
        if (isset($data['Address'])) {
            $this->address = new Address($data['Address']);
        }

        $this->AttentionName = isset($data['AttentionName']) ? $data['AttentionName'] : null;

        if (isset($data['Phone'])) {
            $this->address = new Phone($data['Phone']);
        }
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate($data)
    {
        $this->name = isset($data->Name) ? $data->Name : null;
        $this->AttentionName = isset($data->AttentionName) ? $data->AttentionName : null;
        $this->phone = isset($data->Phone) ? $data->Phone : null;

        if (isset($data->Address)) {
            $this->address = new Address();
            $this->address->populate($data->Address);
        }
    }

    public function address($data)
    {
        $address = new Address($data);
        $this->setAddress($address);

        return $address;
    }

    public function phone($data)
    {
        $address = new Phone($data);
        $this->setPhone($address);

        return $phone;
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

    public function getAttentionName()
    {
        return $this->AttentionName;
    }

    public function setAttentionName($AttentionName)
    {
        $this->AttentionName = $AttentionName;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        return $this;
        $this->address = $address;
    }

}
