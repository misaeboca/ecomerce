<?php

namespace App\Http\Controllers\Common;

use DB;
use Mail;
use App\Payments\Interfaces\IPaymentMethod;
use App\Deliveries\Interfaces\IDeliveryMethod;
use App\Clients\Interfaces\IClientMethod;
use App\Deliveries\MainDeliveryMethod;
use App\Http\Controllers\Controller;
use App\Deliveries\Ups\UpsDelivery;


class UpsController extends Controller
{

    public function enviar(Request $request, IDeliveryMethod $deliveryMethod)
    {
  
        $data = $request->all();

        $store = Store::whereId($order->id_store)->first();
        
        $ups = new UpsDelivery(1, null, 0);

        $ups->createD();
        
        return response()->json(['state' => 'success', 'response' => $cost], 200);
    }

}
