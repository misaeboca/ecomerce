<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Route;

class ParametersProducts
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
        $product = Route::current()->parameter('product');

        if($product && $product >= '') {
            $request->request->add(['product' => $product]);
        }

        $id_store = Route::current()->parameter('id_store');

        if($id_store && $id_store >= '') {
            $request->request->add(['id_store' => $id_store]);
        }

        return $next($request);

    }

}
