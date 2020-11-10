<?php

namespace App\Http\Middleware\Admin;

use App\Models\Admin\Order;
use App\Models\Common\Payment;
use Closure;
use Illuminate\Support\Facades\Route;

class ParametersOrdersUpc
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
        $id_order = Route::current()->parameter('id_order');
        $order = Order::whereId($id_order)->whereStatus(ORDER::STATUS_PENDING)->first();
        $payment = Payment::whereId($order['id_payment'])->first();
        $request->request->add(['id_payment' => $payment['slug']]);
        return $next($request);

    }

}
