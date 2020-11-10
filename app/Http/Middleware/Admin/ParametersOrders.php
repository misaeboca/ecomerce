<?php

namespace App\Http\Middleware\Admin;

use App\Models\Admin\Order;
use Closure;
use Illuminate\Support\Facades\Route;

class ParametersOrders
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

        if($id_order && $id_order >= '') {
            $order = Order::whereId($id_order)->first();
            $request->request->add(['id_order' => $id_order]);
            $request->request->add(['id_store' => $order->id_store]);
            $request->request->add(['id_payment' => $order->id_payment]);
        }

        return $next($request);

    }

}
