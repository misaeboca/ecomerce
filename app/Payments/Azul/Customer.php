<?php

namespace App\Payments\Azul;

use App\Payments\MainCustomer;

class Customer extends MainCustomer
{
	private $channel="EC";
	private $store;
	private $PosInputMode="E-Commerce"; //proporcinados por azul
    private $phone;

	public function __construct($data)
    {
    	parent::__construct($data);
    }

    public function getChannel(){
    	return $this->channel;
    }

    public function getStore(){
    	return $this->store;
    }

    public function getPosInputMode(){
    	return $this->PosInputMode;
    }
}
