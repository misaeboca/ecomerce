<?php

namespace App\Http\Middleware\Admin;

use App\Models\Admin\User;
use Closure;

class IsAuthenticate
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

        if (isset($user) && (!is_null($user) || !empty($user)))
        {
            $request->request->add(['user' => $user]);
            return $next($request);
        }

        return response()->json(['state' => 'fail', 'errors' => 'not_login'], 401);

    }

}
