<?php

    /**
     * @api {get} /admin/stores/{usc}/detail Detail
     * @apiGroup Stores
     * @apiName Detail
     * @apiDescription Obtiene los detalles de <code>USC</code>.
     * @apiUse HeaderExample
     *
     * @apiParam {String} sku Get list of page <code>page</code> by default 1.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": {
                "name": "dos",
                "country": null,
                "city": "São Paulo",
                "address": "Av. Regente Feijó, 1739 - Tatuapé (Loja OQ 147)",
                "cep": "03342-000",
                "usc": "4k20209FOu0816d5awc122506cpL39",
                "email": "brazil.analia.dos@pandorastores.net",
                "phone": "1155052164",
                "logo": null,
                "domain": "http://pandora.flexystore.com/dos",
                "coordinates": "{\"lat\":-46.6960692,\"lng\":-23.6142521}",
                "created_at": "2020-08-16T00:25:06.000000Z",
                "updated_at": "2020-08-16T00:25:11.000000Z",
                "sigla": null,
                "google_tag_manager": null,
                "pixel_facebook": null,
                "loggi": {
                    "user": "mprios@pandora.net",
                    "password": "1234",
                    "api_key": "2e0f3c609336590bc1d73c1a3da79c89c9e01267",
                    "shop": "6522",
                    "distance": 5000,
                    "created_at": "2020-08-16T00:25:11.000000Z",
                    "updated_at": "2020-08-16T00:25:11.000000Z"
                }
            }
        }
    */

    /**
     * @api {get} /admin/stores/{usc}/users Users
     * @apiGroup Stores
     * @apiName Users
     * @apiDescription Retorna el listado de los usuarios de la tienda <code>id</code>.
     * @apiUse HeaderExample
     *
     * @apiParam {String} sku Get list of page <code>page</code> by default 1.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
         {
            "state": "success",
            "msg": "added"
         }
    */

    /**
     * @api {get} /admin/stores/list List
     * @apiGroup Stores
     * @apiName List
     * @apiDescription Retona el listado de tiendas.
     * @apiUse HeaderExample
     *
     * @apiParam {Number} [page] Get list of page <code>page</code> by default 1.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": {
                "current_page": 1,
                "data": [
                    {
                        "name": "dos",
                        "country": null,
                        "city": "São Paulo",
                        "address": "Av. Regente Feijó, 1739 - Tatuapé (Loja OQ 147)",
                        "cep": "03342-000",
                        "usc": "4k20209FOu0816d5awc122506cpL39",
                        "email": "brazil.analia.dos@pandorastores.net",
                        "phone": "1155052164",
                        "logo": null,
                        "domain": "http://pandora.flexystore.com/dos",
                        "coordinates": "{\"lat\":-46.6960692,\"lng\":-23.6142521}",
                        "created_at": "2020-08-16T00:25:06.000000Z",
                        "updated_at": "2020-08-16T00:25:11.000000Z",
                        "sigla": null,
                        "google_tag_manager": null,
                        "pixel_facebook": null,
                        "loggi": {
                            "user": "mprios@pandora.net",
                            "password": "1234",
                            "api_key": "2e0f3c609336590bc1d73c1a3da79c89c9e01267",
                            "shop": "6522",
                            "distance": 5000,
                            "created_at": "2020-08-16T00:25:11.000000Z",
                            "updated_at": "2020-08-16T00:25:11.000000Z"
                        }
                    }
                ],
                "first_page_url": "http://pandora.local/api/v1/admin/stores/list?page=1",
                "from": 1,
                "last_page": 1,
                "last_page_url": "http://pandora.local/api/v1/admin/stores/list?page=1",
                "next_page_url": null,
                "path": "http://pandora.local/api/v1/admin/stores/list",
                "per_page": 10,
                "prev_page_url": null,
                "to": 1,
                "total": 1
            }
        }
     *
    */

    /**
     * @api {post} /admin/stores Add
     * @apiGroup Stores
     * @apiName Add
     * @apiDescription Permite registrar una nueva Teinda.
     * @apiUse HeaderExample
     *
     * @apiUse StoreParams
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "create"
     *   }
     *
     * @apiError require the field is required.
     * @apiError no_create El Store no pudo ser creado.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_create"
     *     }
     *
    */

    /**
     * @api {put} /admin/stores/{usc}/update Update
     * @apiGroup Stores
     * @apiName Update
     * @apiDescription Permite actualizar los datos de un Store.
     * @apiUse HeaderExample
     *
     * @apiUse StoreParams
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "update"
     *   }
     *
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_update El Store no se pudo actualizar, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_update"
     *     }
     *
    */

    /**
     * @api {put} /admin/stores/{usc}/trash Trash
     * @apiGroup Stores
     * @apiName Trash
     * @apiDescription Permite enviar un produto a la papelera.
     * @apiUse HeaderExample
     *
     * @apiParam {Number} usc <code>Id</code> del <code>Store</code>.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "trashed"
     *   }
     *
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_update El Store no se pudo actualizar, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_trashed"
     *     }
     *
    */

    /**
     * @api {put} /admin/stores/{usc}/restore Restore
     * @apiGroup Stores
     * @apiName Restore
     * @apiDescription Permite restaurar una store enviado a la papelera.
     * @apiUse HeaderExample
     *
     * @apiParam {Number} usc <code>Id</code> of <code>Store</code>.
     *
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "restore"
     *   }
     *
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_restore El Store no se pudo actualizar, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_restore"
     *     }
     *
    */

    /**
     * @api {put} /admin/stores/{usc}/addUser AddUser
     * @apiGroup Stores
     * @apiName AddUser
     * @apiDescription Permite restaurar una store enviado a la papelera.
     * @apiUse HeaderExample
     *
     * @apiParam {Number} usc <code>Id</code> del <code>Store</code>.
     * @apiParam {String} username Account of <code>Store</code>.  Max 255 caracter.
     * @apiParam {String} email Account of <code>Store</code>. Max 255 caracter.
     * @apiParam {String} password Account of <code>Store</code>. Max 255 caracter.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "added"
     *   }
     *
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_restore El Store no se pudo actualizar, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_added"
     *     }
     *
    */

    /**
     * @api {put} /admin/stores/{usc}/addFeatures AddFeatureds
     * @apiGroup Products
     * @apiName AddFeatureds
     * @apiDescription Permite crear grupos de productos descatados de una tienda por medio de su<code>id</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://flowdevs.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/featureds"
     *    }
     *
     * @apiParam {String} usc Código único de tienda. Máximo 30 caracteres.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "added"
     *   }
     *
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_update El listado de productos no pudo ser destacado, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *    HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_added"
     *     }
     *
    */
