<?php

namespace App\Payments\Azul;

class Store  implements \JsonSerializable
{
	private $store;

	public function __construct($data = null)
    {
    	$this->store = isset($data['id_store'])? $data['id_store']: null;
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate($data = null)
    {
       $this->store = isset($data->id_store)? $data->id_store: null;
    }


    public function getStore()
    {
    	return $this->store;
    }

    public  function setStore($store)
    {
        $this->store = $store;
        return $this;
    }
}
