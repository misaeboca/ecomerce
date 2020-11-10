<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Route;

class ParametersSharesTypes
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
        $ushtc = Route::current()->parameter('id_share_type');

        if($ushtc && $ushtc >= '') {
            $request->request->add(['id_share_type' => $ushtc]);
        }

        return $next($request);

    }

}
