<?php


    /**
     * @api {get} /admin/products/{sku}/detail Detail
     * @apiGroup Products
     * @apiName Detail
     * @apiDescription Retorna la informacion completa de un producto asociado al <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiParam {String} sku codigo unico de producto.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
         {
            "state": "success",
            "response": {
                "name": "Pulsera",
                "sku": "590702H2V",
                "html_description": null,
                "html_short_description": null,
                "sale_price": null,
                "categories": "root,oro,mate",
                "type": "aro",
                "material": "oro",
                "theme": "boda",
                "tags": null,
                "weight": null,
                "height": null,
                "width": null,
                "length": null,
                "title": null,
                "desc": null,
                "manufacturer": null,
                "status": "active",
                "created_at": "2020-08-16T00:26:41.000000Z",
                "updated_at": "2020-08-16T00:26:41.000000Z",
                "images": [
                    {
                        "url": "https://lorempixel.com/640/480/?57604",
                        "id": "jqRnC1XsvTvyJWkpg9x93R9i83ebpX",
                        "created_at": "2020-08-16T00:26:41.000000Z",
                        "updated_at": "2020-08-16T00:26:41.000000Z",
                    },
                    {
                        "url": "https://lorempixel.com/640/480/?96069",
                        "id": "N0k85pUR1khU3Y57gdrK2snbw6C8P3",
                        "created_at": "2020-08-16T00:26:41.000000Z",
                        "updated_at": "2020-08-16T00:26:41.000000Z"
                    }
                ]
            }
        }
     *
    */

    /**
     * @api {get} /admin/products/list List
     * @apiGroup Products
     * @apiName List
     * @apiDescription Retorna un listado de productos paginados, el valor por defecto es la página 1.
     * @apiUse HeaderExample
     *
     * @apiParam {Number} [page] Parámetro opcional para obtener el listado de la pagina <code>page</code> por defecto este valor es 1.
     * @apiParam {String} [search] Retorna los productos que coincidan con el elemento buscado del parámetro <code>search</code> de forma paginada.
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
       {
            "state": "success",
            "response": {
                "current_page": 1,
                "data": [
                    {
                        "name": "Pulsera",
                        "sku": "590702H2V1",
                        "html_description": null,
                        "html_short_description": null,
                        "sale_price": null,
                        "categories": "root,oro,mate",
                        "type": "aro",
                        "material": "oro",
                        "theme": "boda",
                        "tags": null,
                        "weight": null,
                        "height": null,
                        "width": null,
                        "length": null,
                        "title": null,
                        "desc": null,
                        "manufacturer": null,
                        "status": "active",
                        "created_at": "2020-08-16T00:28:05.000000Z",
                        "updated_at": "2020-08-16T00:28:05.000000Z",
                        "images": [
                            {
                                "url": "http://local.com/test.jpg",
                                "id": "2020tIJib0817gKy7s081337TWoG7I",
                                "created_at": "2020-08-17T20:13:37.000000Z",
                                "updated_at": "2020-08-17T20:13:37.000000Z"
                            },
                            {
                                "url": "http://local.com/test2.jpg",
                                "id": "2020O3ZjH0817pLLKV081337s1wIFb",
                                "created_at": "2020-08-17T20:13:37.000000Z",
                                "updated_at": "2020-08-17T20:13:37.000000Z"
                            }
                        ]
                    },
                    {
                        "name": "Anillo",
                        "sku": "590702H2V",
                        "html_description": null,
                        "html_short_description": null,
                        "sale_price": null,
                        "categories": "root,oro,mate",
                        "type": "aro",
                        "material": "oro",
                        "theme": "boda",
                        "tags": null,
                        "weight": null,
                        "height": null,
                        "width": null,
                        "length": null,
                        "title": null,
                        "desc": null,
                        "manufacturer": null,
                        "status": "active",
                        "created_at": "2020-08-16T00:26:41.000000Z",
                        "updated_at": "2020-08-16T00:26:41.000000Z",
                        "images": []
                    }
                ],
                "first_page_url": "http://pandora.local/api/v1/admin/products/list?page=1",
                "from": 1,
                "last_page": 1,
                "last_page_url": "http://pandora.local/api/v1/admin/products/list?page=1",
                "next_page_url": null,
                "path": "http://pandora.local/api/v1/admin/products/list",
                "per_page": 10,
                "prev_page_url": null,
                "to": 2,
                "total": 2
            }
        }
     *
     * @apiSampleRequest http://flowdevs.com/api/v1/products/list/
    */

    /**
     * @api {get} /admin/products/list ListFeatureds
     * @apiGroup Products
     * @apiName ListFeatureds
     * @apiDescription Retorna un listado de productos destacados, agrupados por su <code>group</code> y paginados, el valor por defecto es la página 1.
     * @apiUse HeaderExample
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
       {
            "state": "success",
            "response": {
                "2": [
                    {
                        "name": "Pulsera",
                        "sku": "590702H2V1",
                        "html_description": null,
                        "html_short_description": null,
                        "sale_price": null,
                        "categories": "root,oro,mate",
                        "type": "aro",
                        "material": "oro",
                        "theme": "boda",
                        "tags": null,
                        "weight": null,
                        "height": null,
                        "width": null,
                        "length": null,
                        "title": null,
                        "desc": null,
                        "manufacturer": null,
                        "status": "active",
                        "created_at": "2020-08-16T00:28:18.000000Z",
                        "updated_at": "2020-08-16T00:28:18.000000Z",
                        "usc": "4k20209FOu0816d5awc122506cpL39",
                        "group": "2",
                        "images": [
                            {
                                "url": null,
                                "id": "2020oBJqx0817x3Gex073607moPwMD",
                                "created_at": "2020-08-17T19:36:07.000000Z",
                                "updated_at": "2020-08-17T19:36:07.000000Z"
                            },
                            {
                                "url": "http://local.com/test.jpg",
                                "id": "2020tIJib0817gKy7s081337TWoG7I",
                                "created_at": "2020-08-17T20:13:37.000000Z",
                                "updated_at": "2020-08-17T20:13:37.000000Z"
                            },
                            {
                                "url": "http://local.com/test2.jpg",
                                "id": "2020O3ZjH0817pLLKV081337s1wIFb",
                                "created_at": "2020-08-17T20:13:37.000000Z",
                                "updated_at": "2020-08-17T20:13:37.000000Z"
                            }
                        ]
                    },
                    {
                        "name": "Anillo",
                        "sku": "590702H2V",
                        "html_description": null,
                        "html_short_description": null,
                        "sale_price": null,
                        "categories": "root,oro,mate",
                        "type": "aro",
                        "material": "oro",
                        "theme": "boda",
                        "tags": null,
                        "weight": null,
                        "height": null,
                        "width": null,
                        "length": null,
                        "title": null,
                        "desc": null,
                        "manufacturer": null,
                        "status": "active",
                        "created_at": "2020-08-16T00:27:05.000000Z",
                        "updated_at": "2020-08-16T00:27:05.000000Z",
                        "usc": "4k20209FOu0816d5awc122506cpL39",
                        "group": "2",
                        "images": []
                    }
                ],
                "3": [
                    {
                        "name": "Pulsera",
                        "sku": "590702H2V1",
                        "html_description": null,
                        "html_short_description": null,
                        "sale_price": null,
                        "categories": "root,oro,mate",
                        "type": "aro",
                        "material": "oro",
                        "theme": "boda",
                        "tags": null,
                        "weight": null,
                        "height": null,
                        "width": null,
                        "length": null,
                        "title": null,
                        "desc": null,
                        "manufacturer": null,
                        "status": "active",
                        "created_at": "2020-08-16T00:33:09.000000Z",
                        "updated_at": "2020-08-16T00:33:09.000000Z",
                        "usc": "4k20209FOu0816d5awc122506cpL39",
                        "group": "3",
                        "images": [
                            {
                                "url": "http://local.com/test.jpg",
                                "id": "2020tIJib0817gKy7s081337TWoG7I",
                                "created_at": "2020-08-17T20:13:37.000000Z",
                                "updated_at": "2020-08-17T20:13:37.000000Z"
                            },
                            {
                                "url": "http://local.com/test2.jpg",
                                "id": "2020O3ZjH0817pLLKV081337s1wIFb",
                                "created_at": "2020-08-17T20:13:37.000000Z",
                                "updated_at": "2020-08-17T20:13:37.000000Z"
                            }
                        ]
                    }
                ],
                "1": [
                    {
                        "name": "Anillo",
                        "sku": "590702H2V",
                        "html_description": null,
                        "html_short_description": null,
                        "sale_price": null,
                        "categories": "root,oro,mate",
                        "type": "aro",
                        "material": "oro",
                        "theme": "boda",
                        "tags": null,
                        "weight": null,
                        "height": null,
                        "width": null,
                        "length": null,
                        "title": null,
                        "desc": null,
                        "manufacturer": null,
                        "status": "active",
                        "created_at": "2020-08-16T00:27:05.000000Z",
                        "updated_at": "2020-08-16T00:27:05.000000Z",
                        "usc": "4k20209FOu0816d5awc122506cpL39",
                        "group": "1",
                        "images": []
                    }
                ]
            }
        }
     *
     * @apiSampleRequest http://flowdevs.com/api/v1/products/list/
    */

    /**
     * @api {post} /admin/products Add
     * @apiGroup Products
     * @apiName Add
     * @apiDescription Permite agregar nuevo producto
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://flowdevs.com/api/v1/products"
     *    }
     *
     * @apiHeaderExample {json} Body-Example:
     *    {
     *         "name": "Pulsera",
     *         "sku": "590702HV",
     *         "categories": "root,oro,mate",
     *         "sale_price": null,
     *         "type": "aro",
     *         "material": "oro",
     *         "theme": "boda",
     *         "html_description": "<html><head><title>Numquam quo dignissimos facilis eaque.</title></head><body><form action="example.com" method="POST"><label for="username">voluptas</label><input type="text" id="username"><label for="password">commodi</label><input type="password" id="password"></form>Et consequuntur at error id est accusantium.<h3>Qui ut rerum.</h3></body></html>",
     *         "html_short_description": null,
     *         "tags": null,
     *         "weight": null,
     *         "height": null,
     *         "width": null,
     *         "length": null,
     *         "title": null,
     *         "desc": null,
     *         "manufacturer": null
     *    }
     *
     * @apiUse ProductParams
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "create"
     *   }
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_create El producto no pudo ser creado, contacte con el administrador.
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
     * @api {put} /admin/products/{sku} Update
     * @apiGroup Products
     * @apiName Update
     * @apiDescription Permite actualizar los datos de un producto por medio de su <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://flowdevs.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn"
     *    }
     *
     * @apiHeaderExample {json} Body-Example:
     *    {
     *         "name": "Pulsera en Plata",
     *         "sku": "590702HV",
     *         "categories": "root,oro,mate",
     *         "sale_price": null,
     *         "type": "aro",
     *         "material": "oro",
     *         "theme": "boda",
     *         "html_description": "<html><head><title>Numquam quo dignissimos facilis eaque.</title></head><body><form action="example.com" method="POST"><label for="username">voluptas</label><input type="text" id="username"><label for="password">commodi</label><input type="password" id="password"></form>Et consequuntur at error id est accusantium.<h3>Qui ut rerum.</h3></body></html>",
     *         "html_short_description": null,
     *         "tags": null,
     *         "weight": null,
     *         "height": null,
     *         "width": null,
     *         "length": null,
     *         "title": null,
     *         "desc": null,
     *         "manufacturer": null
     *    }
     *
     * @apiUse ProductParams
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
     * @apiError no_update El producto no pudo ser actualizado, contacte con el administrador.
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
     * @api {put} /admin/products/{sku}/trash Trash
     * @apiGroup Products
     * @apiName Trash
     * @apiDescription Permite enviar un producto a la papelera por medio de su <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://flowdevs.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/trash"
     *    }
     *
     * @apiParam {String} sku Código único de producto. Máximo 30 caracteres.
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
     * @apiError no_update El producto no pudo ser actualizado, contacte con el administrador.
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
     * @api {put} /admin/products/{sku}/restore Restore
     * @apiGroup Products
     * @apiName Restore
     * @apiDescription Permite restaurar un producto enviado a la papelera por medio de su <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://flowdevs.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/restore"
     *    }
     *
     * @apiParam {String} sku Código único de producto. Máximo 30 caracteres.
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
     * @apiError no_update El producto no pudo ser actualizado, contacte con el administrador.
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
     * @api {post} /admin/products/{sku}/images AddImage
     * @apiGroup Products
     * @apiName AddImage
     * @apiDescription Permite agregar imagenes a un producto por medio de su <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Body-Example:
        {
        "urls": [
                {"url": "http://local.com/test.jpg"},
                {"url": "http://local.com/test2.jpg"}
            ]
        }
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://flowdevs.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/images"
     *    }
     *
     * @apiParam {String} sku Código único de producto. Máximo 30 caracteres.
     * @apiParam {String} urls Lista de <code>URL</code> de la imagen del producto.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "add_image"
     *   }
     *
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_update El producto no pudo ser actualizado, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *    HTTP/1.1 401 Not Found
     *    {
     *      "state": "fail",
     *      "errors": "no_update"
     *    }
     *
    */

    /**
     * @api {delete} /admin/products/{sku}/images/{id} DeleteImage
     * @apiGroup Products
     * @apiName DeleteImage
     * @apiDescription Delete image of Producto
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://flowdevs.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/images/2020Dzx9h0718uhSR5082405Imk6VK"
     *    }
     *
     * @apiParam {String} sku Código único de producto. Máximo 30 caracteres.
     * @apiParam {String} id Código único de imagen de un producto.
     *
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "image_deleted"
     *   }
     *
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_update El producto no pudo ser actualizado, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_update"
     *     }
     *
    */
