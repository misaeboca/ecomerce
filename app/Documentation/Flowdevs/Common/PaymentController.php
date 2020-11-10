<?php


    /**
     * @api {get} /Payments/list List
     * @apiGroup Payments
     * @apiName List
     * @apiDescription Obtiene lalista de metodos de pago.
     * @apiUse HeaderCommonExample
     *
     * @apiParam {Number} [page] Parámetro opcional para obtener el listado de la pagina <code>page</code> por defecto este valor es 1.
     * @apiParam {String} [search] Retorna las órdenes que coincidan con el elemento buscado del parámetro <code>search</code> de forma paginada.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": [
                {
                    "name": "Braspag",
                    "upc": "1J2020y0815I1152289g"
                },
                {
                    "name": "Paypal",
                    "upc": "VE2020j0815x115228ai"
                }
            ]
        }
     *
    */
