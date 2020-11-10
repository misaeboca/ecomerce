<?php

namespace App\Http\Middleware\Admin;

use Illuminate\Support\Facades\Route;
use Closure;

class ParametersPublic
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
        $id_store = Route::current()->parameter('id_store');

        if($id_store && $id_store != '') {
            $request->request->add(['id_store' => $id_store]);
        }

        return $next($request);

    }

}
