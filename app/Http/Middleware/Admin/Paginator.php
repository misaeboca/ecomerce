<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Pagination\AbstractPaginator;

class Paginator
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
        $page = 1;
        $data = $request->all();

        if(isset($data['page']) && $data['page'] > 1) {
            $page = intVal($data['page']);
        }

        AbstractPaginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        return $next($request);

    }

}
