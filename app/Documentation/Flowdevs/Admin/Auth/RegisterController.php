<?php


    /**
     * @api {post} /register Registrar
     * @apiGroup Auth
     * @apiName Register
     * @apiDescription Permite crear una nueva cuenta de tienda maestra.
     * @apiUse HeaderCommonExample
     *
     * @apiParam {String} username Nombre de <code>Usuario</code>.
     * @apiParam {Email} email Correo electronico del <code>Usuario</code>.
     * @apiParam {String} password  Contraseña del <code>Usuario</code>. Minimo 8 caracateres, al menos 1 letra y 1 numero. Ejemplo <code>a1b2c3d4</code>.
     *
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "account_create",
     *       "data": {
     *           "token": "eyJ0eXAiOiJKV1QiLCJhbGciOi12IUzI1NiJ9.eyJpc3MiOiJodXC9hcGlcvXC9wbGFuZXRhLmxvY2FsXC9hcGlcL3YxXC9yZWdpc3RlciIsImlhdCI6MTU4NjY1NDUwNSwiZXhwIjoxNTg2NjU4MTA1LCJuYmYiOjE1ODY2NTQ1MDUsImp0aSI6IlRaT01ubVVHaFRFYWNVTTEiLCJzdWIiOjEwNywicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.onIQ8Z6HpYKVhjy3_qqNXbnKTEIbenBq_7_lzbS1Mic",
     *           "roles": [
     *              {
     *               "id": 8,
     *               "name": "user"
     *              }],
     *       "user": {
     *           "username": "jhondoe",
     *           "email": "jhondoe@planetaerotic.com",
     *           "slug": "MaJ202004IT1201ubM2144",
     *           }
     *       }
     *   }
     * @apiError require <code>{field}</code> El campo es obligatorio.
     * @apiError min_string El campo no cumple con el minimo de caraceters.
     * @apiError max_string El campo no cumple con el maximo de caraceters.
     * @apiError username El Nombre de <code>Usuario</code> invalido.
     * @apiError email El campo no cumple con un formato valido de correo.
     * @apiError register Hubo un error en el proceso de registro, contacte con un <code>Administrador</code>.
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "username"
     *     }
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "email"
     *     }
     */
