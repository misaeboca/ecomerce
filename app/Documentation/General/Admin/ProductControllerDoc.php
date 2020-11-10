<?php

    /**
     * @api {get} /products/{sku}/detail Detail
     * @apiVersion 1.0.0
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
                "name": "CHARM DE PRATA PENDENTE BRILHANTE LETRA X",
                "sku": "791336CZ",
                "html_description": null,
                "html_short_description": "Charm de Prata de Lei e pendente no formato da letra X adornado com 21 micro pedras lapidadas de zircônia cúbica transparente cravejadas em pavê manualmente pelos artesãos da PANDORA.",
                "sale_price": null,
                "categories": "CHARMS",
                "type": null,
                "material": null,
                "theme": null,
                "tags": null,
                "weight": null,
                "height": null,
                "width": null,
                "length": null,
                "title": null,
                "desc": null,
                "manufacturer": null,
                "status": null,
                "created_at": "2020-09-05T21:18:45.000000Z",
                "updated_at": "2020-09-05T21:18:45.000000Z",
                "deleted_at": null,
                "variations": [
                    {
                        "cod": "U",
                        "sku": "U",
                        "price": 389,
                        "description": "Charm de Prata de Lei e pendente no formato da letra X adornado com 21 micro pedras lapidadas de zircônia cúbica transparente cravejadas em pavê manualmente pelos artesãos da PANDORA.",
                        "extra":"{\"produto\":\"791336CZ\",\"descricao\":\"CHARM PENDENTE BRILHANTE LETRA X\",\"descricaoVitrine\":\"CHARM DE PRATA PENDENTE BRILHANTE LETRA X\",\"codTipo\":\"86\",\"descTipo\":\"ZIRCONIA CUBICA\",\"codGrupo\":\"15\",\"descGrupo\":\"CHARMS\",\"codSubgrupo\":\"5\",\"descSubgrupo\":\"CHARM PENDENTE\",\"codColecao\":\"364\",\"descColecao\":\"2014 - Q1 - DROP 1\",\"codLinha\":\"27\",\"descLinha\":\"PANDORA ID\",\"codGriffe\":\"J\",\"descGriffe\":\"JEWELRY\",\"detalhe\":\"Charm de Prata de Lei e pendente no formato da letra X adornado com 21 micro pedras lapidadas de zirc\ônia c\úbica transparente cravejadas em pav\ê manualmente pelos artes\ãos da PANDORA.\",\"dataParaTransferencia\":\"2020-09-04T09:59:00\",\"diasBusca\":1,\"echoCadProdutosSku\":[{\"produto\":\"791336CZ\",\"corProduto\":\"03\",\"sku\":\"791336CZ031\",\"descricao\":\"CHARM PENDENTE BRILHANTE LETRA X-CLEAR-ONE SIZE\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"ONE SIZE\",\"echoCadProdutosBarra\":[{\"produto\":\"791336CZ\",\"corProduto\":\"03\",\"sku\":\"791336CZ031\",\"descricao\":\"CHARM PENDENTE BRILHANTE LETRA X-CLEAR-ONE SIZE\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"ONE SIZE\",\"codigoBarra\":\"5700302226096\"}]}]}",
                        "ean13": "5700302226096",
                        "itf14": null,
                        "created_at": "2020-09-05T21:18:45.000000Z",
                        "updated_at": "2020-09-05T21:18:45.000000Z",
                        "stock": null
                    }
                ],
                "images": [
                    {
                        "id": "F5202009520200908083818tu",
                        "cod": null,
                        "sku": null,
                        "url": "http://domain.com//storage/images/C2020509080838g.jpg",
                        "height": "190",
                        "width": "236",
                        "created_at": "2020-09-08T20:38:18.000000Z",
                        "updated_at": "2020-09-08T20:38:18.000000Z"
                    }
                ]
            }
        }
     *
     */


     /**
     * @api {get} /products/list List
     * @apiVersion 1.0.0
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
                        "name": "CHARM DE PRATA",
                        "sku": "791338CZ",
                        "html_description": null,
                        "html_short_description": "Charm de Prata de Lei e pendente no formato da letra Z adornado com 20 micro pedras lapidadas de zircônia cúbica transparente cravejadas em pavê manualmente pelos artesãos da PANDORA.",
                        "sale_price": null,
                        "categories": "CHARMS",
                        "type": null,
                        "material": null,
                        "theme": null,
                        "tags": null,
                        "weight": null,
                        "height": null,
                        "width": null,
                        "length": null,
                        "title": null,
                        "desc": null,
                        "manufacturer": null,
                        "status": null,
                        "created_at": "2020-09-05T21:18:45.000000Z",
                        "updated_at": "2020-09-05T21:18:45.000000Z",
                        "deleted_at": null,
                        "variations": [
                            {
                                "cod": "U",
                                "sku": "U",
                                "price": 389,
                                "description": "Charm de Prata de Lei e pendente no formato da letra Z adornado com 20 micro pedras lapidadas de zircônia cúbica transparente cravejadas em pavê manualmente pelos artesãos da PANDORA.",
                                "extra":"{\"produto\":\"791338CZ\",\"descricao\":\"CHARM PENDENTE BRILHANTE LETRA Z\",\"descricaoVitrine\":\"CHARM DE PRATA PENDENTE BRILHANTE LETRA Z\",\"codTipo\":\"86\",\"descTipo\":\"ZIRCONIA CUBICA\",\"codGrupo\":\"15\",\"descGrupo\":\"CHARMS\",\"codSubgrupo\":\"5\",\"descSubgrupo\":\"CHARM PENDENTE\",\"codColecao\":\"364\",\"descColecao\":\"2014 - Q1 - DROP 1\",\"codLinha\":\"27\",\"descLinha\":\"PANDORA ID\",\"codGriffe\":\"J\",\"descGriffe\":\"JEWELRY\",\"detalhe\":\"Charm de Prata de Lei e pendente no formato da letra Z adornado com 20 micro pedras lapidadas de zirc\ônia c\úbica transparente cravejadas em pav\ê manualmente pelos artes\ãos da PANDORA.\",\"dataParaTransferencia\":\"2020-06-11T06:25:00\",\"diasBusca\":86,\"echoCadProdutosSku\":[{\"produto\":\"791338CZ\",\"corProduto\":\"03\",\"sku\":\"791338CZ031\",\"descricao\":\"CHARM PENDENTE BRILHANTE LETRA Z-CLEAR-ONE SIZE\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"ONE SIZE\",\"echoCadProdutosBarra\":[{\"produto\":\"791338CZ\",\"corProduto\":\"03\",\"sku\":\"791338CZ031\",\"descricao\":\"CHARM PENDENTE BRILHANTE LETRA Z-CLEAR-ONE SIZE\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"ONE SIZE\",\"codigoBarra\":\"5700302226119\"}]}]}",
                                "ean13": "5700302226119",
                                "itf14": null,
                                "created_at": "2020-09-05T21:18:45.000000Z",
                                "updated_at": "2020-09-05T21:18:45.000000Z",
                                "stock": null
                            }
                        ],
                        "images": [
                            {
                                "id": "ba202009D20200908083818Kv",
                                "cod": null,
                                "sku": null,
                                "url": "http://domain.com//storage/images/B2020c09080838m.jpg",
                                "height": "190",
                                "width": "236",
                                "created_at": "2020-09-08T20:38:18.000000Z",
                                "updated_at": "2020-09-08T20:38:18.000000Z"
                            }
                        ]
                    },
                    {
                        "name": "CHARM DE PRATA PENDENTE BRILHANTE LETRA Y",
                        "sku": "791337CZ",
                        "html_description": null,
                        "html_short_description": "Charm de Prata de Lei e pendente no formato da letra Y adornado com 14 micro pedras lapidadas de zircônia cúbica transparente cravejadas em pavê manualmente pelos artesãos da PANDORA.",
                        "price": 389,
                        "sale_price": null,
                        "categories": "CHARMS",
                        "type": null,
                        "material": null,
                        "theme": null,
                        "tags": null,
                        "weight": null,
                        "height": null,
                        "width": null,
                        "length": null,
                        "title": null,
                        "desc": null,
                        "manufacturer": null,
                        "status": null,
                        "created_at": "2020-09-05T21:18:45.000000Z",
                        "updated_at": "2020-09-05T21:18:45.000000Z",
                        "deleted_at": null,
                        "variations": [
                            {
                                "cod": "U",
                                "sku": "U",
                                "price": 389,
                                "description": "Charm de Prata de Lei e pendente no formato da letra Y adornado com 14 micro pedras lapidadas de zircônia cúbica transparente cravejadas em pavê manualmente pelos artesãos da PANDORA.",
                                "extra":"{\"produto\":\"791337CZ\",\"descricao\":\"CHARM PENDENTE BRILHANTE LETRA Y\",\"descricaoVitrine\":\"CHARM DE PRATA PENDENTE BRILHANTE LETRA Y\",\"codTipo\":\"86\",\"descTipo\":\"ZIRCONIA CUBICA\",\"codGrupo\":\"15\",\"descGrupo\":\"CHARMS\",\"codSubgrupo\":\"5\",\"descSubgrupo\":\"CHARM PENDENTE\",\"codColecao\":\"364\",\"descColecao\":\"2014 - Q1 - DROP 1\",\"codLinha\":\"27\",\"descLinha\":\"PANDORA ID\",\"codGriffe\":\"J\",\"descGriffe\":\"JEWELRY\",\"detalhe\":\"Charm de Prata de Lei e pendente no formato da letra Y adornado com 14 micro pedras lapidadas de zirc\ônia c\úbica transparente cravejadas em pav\ê manualmente pelos artes\ãos da PANDORA.\",\"dataParaTransferencia\":\"2020-08-17T09:59:00\",\"diasBusca\":19,\"echoCadProdutosSku\":[{\"produto\":\"791337CZ\",\"corProduto\":\"03\",\"sku\":\"791337CZ031\",\"descricao\":\"CHARM PENDENTE BRILHANTE LETRA Y-CLEAR-ONE SIZE\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"ONE SIZE\",\"echoCadProdutosBarra\":[{\"produto\":\"791337CZ\",\"corProduto\":\"03\",\"sku\":\"791337CZ031\",\"descricao\":\"CHARM PENDENTE BRILHANTE LETRA Y-CLEAR-ONE SIZE\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"ONE SIZE\",\"codigoBarra\":\"5700302226102\"}]}]}",
                                "ean13": "5700302226102",
                                "itf14": null,
                                "created_at": "2020-09-05T21:18:45.000000Z",
                                "updated_at": "2020-09-05T21:18:45.000000Z",
                                "stock": null
                            }
                        ],
                        "images": [
                            {
                                "id": "cQ202009X20200908083818ic",
                                "cod": null,
                                "sku": null,
                                "url": "http://domain.com//storage/images/72020v09080838k.jpg",
                                "height": "190",
                                "width": "236",
                                "created_at": "2020-09-08T20:38:18.000000Z",
                                "updated_at": "2020-09-08T20:38:18.000000Z"
                            }
                        ]
                    }
                ],
                "first_page_url": "http://domain.com/api/v1/admin/products/list?page=1",
                "from": 1,
                "last_page": 293,
                "last_page_url": "http://domain.com/api/v1/admin/products/list?page=293",
                "next_page_url": "http://domain.com/api/v1/admin/products/list?page=2",
                "path": "http://domain.com/api/v1/admin/products/list",
                "per_page": 10,
                "prev_page_url": null,
                "to": 10,
                "total": 2928
            }
        }
     *
     * @apiSampleRequest http://domain.com/api/v1/products/list/
     */


    /**
     * @api {post} /products Add
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName Add
     * @apiDescription Permite agregar nuevo producto
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Body-Example:
     *    {
     *         "name": "CHARM DE PRATA",
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
     * @api {put} /products/{sku} Update
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName Update
     * @apiDescription Permite actualizar los datos de un producto por medio de su <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Body-Example:
     *    {
     *         "name": "Pulsera en Plata con Cierre PANDORA con cierre de barril",
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
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://domain.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn"
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
     * @api {put} /products/{sku}/trash Trash
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName Trash
     * @apiDescription Permite enviar un producto a la papelera por medio de su <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://domain.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/trash"
     *    }
     *
     * @apiParam {String} sku Código único de producto. Máximo 30 caracteres.
     *
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
     * @api {put} /products/{sku}/restore Restore
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName Restore
     * @apiDescription Permite restaurar un producto enviado a la papelera por medio de su <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://domain.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/restore"
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
     * @api {post} /products/{sku}/images AddImage
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName AddImage
     * @apiDescription Permite agregar una imagen a un producto por medio de su <code>sku</code>.
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
     *         "http://domain.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/images"
     *    }
     *
     * @apiParam {String} sku Código único de producto. Máximo 30 caracteres.
     * @apiParam {String} url URL de la imagen del producto.
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
     *     {
     *       "state": "fail",
     *       "errors": "no_update"
     *     }
     *
     */


    /**
     * @api {delete} /products/{sku}/images/{id} DeleteImage
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName DeleteImage
     * @apiDescription Delete image of Producto
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://domain.com/api/v1/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/images/2020Dzx9h0718uhSR5082405Imk6VK"
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
