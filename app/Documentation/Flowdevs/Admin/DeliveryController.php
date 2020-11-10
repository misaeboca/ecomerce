<?php

    /**
     * @api {get} /admin/deliveries/list Deliveries
     * @apiGroup Commons
     * @apiName Deliveries
     * @apiDescription Obtiene el listado de los metodos de envio.
     * @apiUse HeaderCommonExample
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": [
                {
                    "name": "Loggi",
                    "id": "VlgZ7aQPqA",
                    "created_at": "2020-08-15T23:52:28.000000Z",
                    "updated_at": "2020-08-15T23:52:28.000000Z",
                    "slug": "loggi"
                },
                {
                    "name": "Champlin",
                    "id": "Tag5X0NV1O",
                    "created_at": "2020-08-15T23:52:28.000000Z",
                    "updated_at": "2020-08-15T23:52:28.000000Z",
                    "slug": "arnold-champlin"
                },
                {
                    "name": "Elnora",
                    "id": "NAjreP7UQr",
                    "created_at": "2020-08-15T23:52:28.000000Z",
                    "updated_at": "2020-08-15T23:52:28.000000Z",
                    "slug": "prof.-elnora-armstrong-iv"
                },
                {
                    "name": "Ethyl",
                    "id": "RLHwK78KFo",
                    "created_at": "2020-08-15T23:52:28.000000Z",
                    "updated_at": "2020-08-15T23:52:28.000000Z",
                    "slug": "ethyl-west-dvm"
                }
            ]
        }
    */
