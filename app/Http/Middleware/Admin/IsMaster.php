<?php

namespace App\Http\Middleware\Admin;

use App\Models\Admin\User;
use Closure;

class IsMaster
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
        if($user->hasRole(['root', 'master']))
        {
            return $next($request);
        }

        return response()->json(['state' => 'fail', 'msg' => 'insufficient_role'], 404);

    }

}
