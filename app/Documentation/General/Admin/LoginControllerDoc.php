<?php

    /**
     * @api {post} /authenticate Authenticate
     * @apiVersion 1.0.0
     * @apiGroup Auth
     * @apiName Authenticate
     * @apiDescription Permite iniciar sesion, retorna el <code>access_token</code>.
     * @apiUse HeaderCommonExample
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
     * @apiSampleRequest http://domain.com/api/v1/authenticate
     */


