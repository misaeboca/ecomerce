<?php

namespace App\Http\Middleware\Admin;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\PayloadException;
use Tymon\JWTAuth\Exceptions\InvalidClaimException;
use Tymon\JWTAuth\Exceptions\JWTException;

class VerifyJWTToken
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
        try {
    		if (! $token = JWTAuth::getToken()) {
                return response()->json(['msg' => 'token.not_provided'], 400);
            }
            if (! $user = JWTAuth::parseToken()->authenticate()) {
               return response()->json(['msg' => 'user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            logError('TokenExpiredException: ' .$e->getMessage());
            return response()->json(['msg' => 'token.expired'], 401); //$statusCode = 401

        } catch (TokenBlacklistedException $e) {
            logError('TokenBlacklistedException: ' .$e->getMessage());
            return response()->json(['msg' => 'token.blacklisted'], 401); //$statusCode = 401

        } catch (TokenInvalidException $e) {
            logError('TokenInvalidException: ' .$e->getMessage());
            return response()->json(['msg' => 'token.invalid'], 400); //$statusCode = 400

        } catch (PayloadException $e) {
            logError('PayloadException: ' .$e->getMessage());
            return response()->json(['msg' => 'token.expired'], 500); //$statusCode = 500

        } catch (InvalidClaimException $e) {
            logError('InvalidClaimException: ' .$e->getMessage());
            return response()->json(['msg' => 'token.invalid'], 400); //$statusCode = 400

        } catch (JWTException $e) {
            logError('JWTException: ' .$e->getMessage());
            return response()->json(['msg' => 'token.absent'], 500); //$statusCode = 500

        } catch (\Exception $e) {
            logError('Exception: ' .$e->getMessage());
            return response()->json(['msg' => 'token.invalid'], 500); //$statusCode = 500
        }

        return $next($request);
    }
}
