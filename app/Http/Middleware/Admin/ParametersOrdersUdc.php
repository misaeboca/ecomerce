<?php

namespace App\Http\Middleware\Admin;

use App\Models\Admin\Delivery;
use App\Models\Admin\Payment;
use App\Models\Common\Store;
use Closure;

class ParametersOrdersUdc
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = $request->all();

        $store = Store::whereId($request->input('id_store'))->first();
        $udc = isset($data['customer']['id_delivery']) ? $data['customer']['id_delivery'] : null;
        $delivery = Delivery::whereId($udc)->first();
        $slug = null;
        $free_amount = null;
        $pay = null;
        if($delivery)
        {
            $slug = $delivery['slug'];
            $free_amount = $delivery['free_amount'];
        }

        if(!isset(($data['payment']['id_payment'])))
        {
            return response()->json(['state' => 'fail', 'errors' => 'invalid.payment'], 401);
        }

        $payment = Payment::whereId($data['payment']['id_payment'])->first();
        if($payment)
        {
            $pay = $payment['slug'];
        }

        $request->request->add(['udc_slug' => $slug, 'free_amount' => $free_amount, 'id_payment' => $pay, 'id_client' => $store->id_client]);

        return $next($request);

    }

}
