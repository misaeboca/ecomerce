<?php

    /**
     * @api {post} /authenticate Authenticate
     * @apiVersion 1.0.0
     * @apiGroup Auth
     * @apiName Authenticate
     * @apiDescription Permite iniciar sessão, devolve o <code>access token</code>
     * @apiUse HeaderCommonExample
     *
     * @apiParam {String} username Nome de usuário.
     * @apiParam {Email} [email] E-mail do usuário. Parâmetro opcional para início de sessão em troca do <code>username</code>.
     * @apiParam {String} password Senha do usuário. Mínimo de 8 caracteres, obrigatória pelo menos 1 letra e 1 número. Exemplo: <code>a1b2c3d4</code>.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "access_token":  "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ19.eyJpc3MiOiJodHRwOlwvXC9wbGFuZXRhLmxvY2FsXC9hcGlcL3YxXC91c2VyXC9sb2dpbiIsImlhdCI6MTU4NjY0MTg2MCwiZXhwIjoxNTg2NjQ1NDYwLCJuYmYiOjE1ODY2NDE4NjAsImp0aSI6IkJqWHlhdHVmZ3ZtRVdYaUciLCJzdWIiOjEwMiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.wOfqbp3tS_zcPB8YrOMNcFTFW5nnnyjYpI9Wnva3bTY"
     *   }
     *
     * @apiError required Campos obrigatórios.
     * @apiError min_string Não cumpre o mínimo de caracteres.
     * @apiError credential As credenciais <code>(username, password)</code> não coincidem.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "credential"
     *     }
     *
     * @apiSampleRequest http://apipandora.wiperagency.com/api/v1/authenticate
     */
