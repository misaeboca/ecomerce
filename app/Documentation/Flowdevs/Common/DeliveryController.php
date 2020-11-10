<?php


    /**
     * @api {get} /deliveries/list List
     * @apiGroup Deliveries
     * @apiName Common
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
                    "id": "VlgZ7aQPqA"
                },
                {
                    "name": "Champlin",
                    "id": "Tag5X0NV1O"
                },
                {
                    "name": "Elnora",
                    "id": "NAjreP7UQr"
                },
                {
                    "name": "Ethyl",
                    "id": "RLHwK78KFo"
                }
            ]
        }
    */
