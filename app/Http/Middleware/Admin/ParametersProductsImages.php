<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Route;

class ParametersProductsImages
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
        $sku = Route::current()->parameter('product');

        if($sku && $sku >= '') {
            $request->request->add(['product' => $sku]);
        }

        $id = Route::current()->parameter('id_image');

        if($id && $id >= '') {
            $request->request->add(['id_image' => $id]);
        }

        $id = Route::current()->parameter('id_category');

        if($id && $id >= '') {
            $request->request->add(['id_category' => $id]);
        }

        return $next($request);

    }

}
