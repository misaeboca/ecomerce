<?php

    /**
     * @api {post} /orders Add
     * @apiGroup Commons
     * @apiName Add
     * @apiDescription Permite registrar una nueva orden
     * @apiUse HeaderExample

     * @apiHeaderExample {json} Body-Example:
        {
            "usc": "4k20209FOu0816d5awc122506cpL39",
            "customer":{
                "name":"jhon",
                "lastname":"doe",
                "email": "jhondoe@gmail.com",
                "phone": "5812345678",
                "cpf": "216354645",
                "deliveryAddress":{
                    "id": "miK4Moq1LI",
                    "street":"Alameda Xingu",
                    "number":"512",
                    "complement":"27th floor",
                    "zip_code":"12345987",
                    "city":"São Paulo",
                    "state":"SP",
                    "country":"BRA",
                    "district":"Alphaville"
                }
            },
            "payment":{
                "upc": "1J2020y0815I1152289g",
                "type":"CreditCard",
                "card":{
                    "cardNumber":"4551870000000181",
                    "holder": "Cardholder Name",
                    "expirationDate":"12/2021",
                    "securityCode":"123",
                    "brand":"Visa"
                }
            },
            "products": [
                {"sku": "590702H2V", "quantity": 5}
            ]
        }

     * @apiUse OrderParams
     * @apiParam {String} id Código único de orden. Máximo 30 caracteres.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": "bQ2020l0818t042316oA"
        }
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_create El Order no pudo ser creado.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_create"
     *     }
    */

