<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Route;

class ParametersCustomers
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
        $ucc = Route::current()->parameter('id_customer');

        if($ucc && $ucc != '') {
            $request->request->add(['id_customer' => $ucc]);
        }

        return $next($request);

    }

}
