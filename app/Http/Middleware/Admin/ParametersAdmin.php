<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Route;

class ParametersAdmin
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
        $id = Route::current()->parameter('id');

        if($id && $id != '') {
            $request->request->add(['id' => $id]);
        }

        $sku = Route::current()->parameter('sku');

        if($sku && $sku != '') {
            $request->request->add(['sku' => $sku]);
        }

        $product = Route::current()->parameter('product');

        if($product && $product >= '') {
            $request->request->add(['product' => $product]);
        }

        $id_store = Route::current()->parameter('id_store');

        if($id_store && $id_store != '') {
            $request->request->add(['id_store' => $id_store]);
        }

        $category = Route::current()->parameter('category');

        if($category && $category != '') {
            $request->request->add(['category' => $category]);
        }

        return $next($request);

    }

}
