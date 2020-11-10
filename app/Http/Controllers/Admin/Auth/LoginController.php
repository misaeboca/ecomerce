<?php

namespace App\Http\Controllers\Admin\Auth;

use JWTAuth;
use App\Models\Admin\User;
use App\Http\Requests\Admin\Auth\AuthenticateRequest;
use App\Http\Controllers\Controller;
use App\Models\GlobalStatus;

class LoginController extends Controller
{

    /**
     * @api {post} /authenticate Authenticate
     * @apiVersion 1.0.0
     * @apiGroup Auth
     * @apiName Authenticate
     * @apiDescription Permite iniciar sesion, retorna el <code>access_token</code>.
     *
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Content-Type": "application/json"
     *     }
     *
     * @apiParam {String} username Nombre del usuario.
     * @apiParam {Email} [email] Correo del usuario. Parametro opcional para iniciar sesion en lugar del <code>username</code>
     * @apiParam {String} password Contraseña del usuario. Minimo 8 caracteres, al menos 1 letra y 1 numero. Ejemplo <code>a1b2c3d4</code>.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "access_token":  "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ19.eyJpc3MiOiJodHRwOlwvXC9wbGFuZXRhLmxvY2FsXC9hcGlcL3YxXC91c2VyXC9sb2dpbiIsImlhdCI6MTU4NjY0MTg2MCwiZXhwIjoxNTg2NjQ1NDYwLCJuYmYiOjE1ODY2NDE4NjAsImp0aSI6IkJqWHlhdHVmZ3ZtRVdYaUciLCJzdWIiOjEwMiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.wOfqbp3tS_zcPB8YrOMNcFTFW5nnnyjYpI9Wnva3bTY"
     *   }
     *
     * @apiError required El campo es obligatorio.
     * @apiError min_string No cumple con el minimo de caraceters.
     * @apiError credential Las credenciales <code>(username, password)</code> no coinciden.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "credential"
     *     }
     *
     * @apiSampleRequest http://flowdevs.com/api/v1/authenticate
     */
    public function authenticate(AuthenticateRequest $request)
    {
        try
        {
            $data = $request->all();

            $user = User::select(['id', 'username', 'email', 'status'])
                ->whereUsername($data['username'])
                ->wherePassword(hash(env('ENCRYPTION_ALGORITHM'), $data['password']))
                ->first();

            if(is_null($user) || empty($user))
            {
                $user = User::select(['id', 'username', 'email', 'status'])
                    ->whereEmail($data['username'])
                    ->wherePassword(hash(env('ENCRYPTION_ALGORITHM'), $data['password']))
                    ->first();
            }

            if($user)
            {
                switch($user['status']) {
                    case GlobalStatus::STATUS_ACTIVE:

                        $token = JWTAuth::fromUser($user);

                        if (!$token)
                        {
                            return response()->json(['state' => 'fail', 'msg' => 'could_not_create_token'], 401);
                        }

                        return response()->json(['state' => 'success', 'access_token' => $token], 200);

                    break;

                    default:
                        return response()->json(['state' => 'fail', 'msg' => 'your_account_has_' . $user['status']], 401);
                    break;

                }
            }

            return response()->json(['state' => 'fail', 'msg' => 'credential'], 401);
        }
        catch (\Exception $e)
        {
            logError('LoginController@authenticate:' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'could_not_create_token'], 403);
        }
    }

}
