<?php

namespace App\Payments\Luka;

use App\Payments\MainCreditCard;

class CreditCard extends MainCreditCard
{
	public function getExpirationDate()
    {
        return $this->expirationDate; 
        
    }
}
