<?php

    /**
     * @api {get} /admin/customers/{id}/detail Detail
     * @apiGroup Customers
     * @apiName Detail
     * @apiDescription Retorna la información completa de una orden asociada al <code>id</code>.
     * @apiUse HeaderExample
     *
     * @apiParam {String} id Código único de orden. Máximo 30 caracteres.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": {
                "ucc": "bA202080818U042316XA",
                "name": "jhon",
                "lastname": "doe",
                "email": "jhondoe@gmail.com",
                "created_at": "2020-08-18T04:23:16.000000Z",
                "updated_at": "2020-08-18T04:23:16.000000Z",
                "cpf": "216354645",
                "phone": "5812345678"
            }
        }
     *
    */

    /**
     * @api {get} /admin/customers/list List
     * @apiGroup Customers
     * @apiName List
     * @apiDescription Get list Customers.
     * @apiUse HeaderExample
     *
     * @apiParam {Number} [page] Parámetro opcional para obtener el listado de la pagina <code>page</code> por defecto este valor es 1.
     * @apiParam {String} [search] Retorna las órdenes que coincidan con el elemento buscado del parámetro <code>search</code> de forma paginada.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": {
                "current_page": 1,
                "data": [
                    {
                        "ucc": "bA202080818U042316XA",
                        "name": "jhon",
                        "lastname": "doe",
                        "email": "jhondoe@gmail.com",
                        "created_at": "2020-08-18T04:23:16.000000Z",
                        "updated_at": "2020-08-18T04:23:16.000000Z",
                        "cpf": "216354645",
                        "phone": "5812345678"
                    }
                ],
                "first_page_url": "http://pandora.local/api/v1/admin/customers/list?page=1",
                "from": 1,
                "last_page": 1,
                "last_page_url": "http://pandora.local/api/v1/admin/customers/list?page=1",
                "next_page_url": null,
                "path": "http://pandora.local/api/v1/admin/customers/list",
                "per_page": 10,
                "prev_page_url": null,
                "to": 1,
                "total": 1
            }
        }
     *
    */
