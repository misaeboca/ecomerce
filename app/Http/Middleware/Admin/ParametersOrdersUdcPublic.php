<?php

namespace App\Http\Middleware\Admin;

use App\Models\Admin\Delivery;
use Closure;

class ParametersOrdersUdcPublic
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
        $slug = null;
        $free_amount = null;

        if(!isset($data['id_delivery']))
        {
            return response()->json(['state' => 'fail', 'errors' => 'invalid.id_delivery'], 401);
        }

        $delivery = Delivery::whereId($data['id_delivery'])->first();

        if($delivery) {
            $slug = $delivery->slug;
            $free_amount = $delivery->free_amount;
        }
        $request->request->add(['udc_slug' => $slug]);
        $request->request->add(['free_amount' => $free_amount]);

        return $next($request);

    }

}
