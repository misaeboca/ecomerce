<?php

namespace App\Http\Middleware\Admin;

use App\Models\Admin\User;
use Closure;

class IsRoot
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
        $user = User::isAuthenticate();
        if($user->hasRole(['root']))
        {
            return $next($request);
        }

        return response()->json(['state' => 'fail', 'msg' => 'insufficient_role'], 404);

    }

}
