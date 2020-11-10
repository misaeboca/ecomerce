<?php

namespace App\Payments\Luka;

class CountryPayment implements \JsonSerializable
{
    private $id_payment;

    private $name;

    private $slug;

    public function __construct($data = null)
    {
     
        $this->id_payment = isset($data['id_payment'])? $data['id_payment']: null;
        $this->name = isset($data['name'])? $data['name']: null;
  
        $this->slug =  $this->slug = isset($data['slug'])? $data['slug']: null;
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate($data = null)
    {
        $this->id_payment = isset($data->id_payment)? $data->id_payment: null;
        $this->name = isset($data->name)? $data->name: null;
        $this->$slug = isset($data->slug)? $data->slug: null;
    }

    public function getIdPayment()
    {
        return $this->id_payment;
    }

    public function setIdPayment()
    {
        $this->id_payment = $id_payment;
        return $this;
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

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

}
