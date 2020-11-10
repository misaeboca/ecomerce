<?php

    /**
     * @api {get} /admin/products/{sku}/detail Detail
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName Detail
     * @apiDescription Retorna a informação completa de um produto associado a <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiParam {String} sku Código único do produto.
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
                        "url": "http://apilanlimp.wiperagency.com//storage/images/C2020509080838g.jpg",
                        "height": "190",
                        "width": "236",
                        "created_at": "2020-09-08T20:38:18.000000Z",
                        "updated_at": "2020-09-08T20:38:18.000000Z"
                    }
                ]
            }
        }
     *
     *
    */

    /**
     * @api {get} /admin/products/list List
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName List
     * @apiDescription Retorna uma lista do produtos por página, o valor por default é a página 1.
     * @apiUse HeaderExample
     *
     * @apiParam {Number} [page] Parâmetro opcional para obter uma lista da página <code>page</code> por default esse valor é 1.
     * @apiParam {String} [search] Retornam os produtos que coincidam com o elemento buscado do parâmetro <code>search</code> de forma paginada.
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
                                "url": "http://apilanlimp.wiperagency.com//storage/images/B2020c09080838m.jpg",
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
                                "url": "http://apilanlimp.wiperagency.com//storage/images/72020v09080838k.jpg",
                                "height": "190",
                                "width": "236",
                                "created_at": "2020-09-08T20:38:18.000000Z",
                                "updated_at": "2020-09-08T20:38:18.000000Z"
                            }
                        ]
                    }
                ],
                "first_page_url": "http://apilanlimp.wiperagency.com/api/v1/admin/products/list?page=1",
                "from": 1,
                "last_page": 293,
                "last_page_url": "http://apilanlimp.wiperagency.com/api/v1/admin/products/list?page=293",
                "next_page_url": "http://apilanlimp.wiperagency.com/api/v1/admin/products/list?page=2",
                "path": "http://apilanlimp.wiperagency.com/api/v1/admin/products/list",
                "per_page": 10,
                "prev_page_url": null,
                "to": 10,
                "total": 2928
            }
        }
     *
    */

    /**
     * @api {post} /admin/products Add
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName Add
     * @apiDescription Permite agregar novo produto.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Body-Example:
     *    {
     *         "name": "CHARM DE PRATA",
     *         "sku": "590702HV",
     *         "categories": "root,oro,mate",
     *         "price": 14500,
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
     * @apiError require Campos obrigatórios.
     * @apiError no_create produto não pode ser criado, entre em contato com o administrador
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
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName Update
     * @apiDescription Permite atualizar os dados de um produto através de <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Body-Example:
     *    {
     *         "name": "CHARM DE PRATA",
     *         "sku": "590702HV",
     *         "categories": "root,oro,mate",
     *         "price": 14500,
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
     *         "http://apilanlimp.wiperagency.com/api/v1/admin/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn"
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
     * @apiError require Campos obrigatórios.
     * @apiError no_update O produto não pode ser atualizado, entre em contato com o administrador
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
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName Trash
     * @apiDescription Permite enviar um produto para o lixo através de <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://apilanlimp.wiperagency.com/api/v1/admin/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/trash"
     *    }
     *
     * @apiParam {String} sku Código único do produto. Máximo 30 caracteres.
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
     * @apiError require Campos obrigatórios.
     * @apiError no_update O produto não pode ser atualizado, entre em contato com o administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_update"
     *     }
    */

    /**
     * @api {put} /admin/products/{sku}/restore Restore
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName Restore
     * @apiDescription Permite restaurar um produto enviado para o lixo através do <code>sku</code>.
     * @apiUse HeaderExample
     *
     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://apilanlimp.wiperagency.com/api/v1/admin/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/restore"
     *    }
     *
     * @apiParam {String} sku Código único do produto. Máximo 30 caracteres.
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
     * @apiError require Campos obrigatórios.
     * @apiError no_update O produto não pode ser atualizado, entre em contato com o administrador.
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
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName AddImage
     * @apiDescription Permite adicionar uma imagem a um produto através de <code>sku</code>.
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
     *         "http://apilanlimp.wiperagency.com/api/v1/admin/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/images"
     *    }
     *
     * @apiParam {String} sku Código único do produto. Máximo 30 caracteres.
     * @apiParam {String} url URL da imagem do produto.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "add_image"
     *   }
     *
     *
     * @apiError require Campos obrigatórios.
     * @apiError no_update O produto não pode ser atualizado, entre em contato com o administrador.
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
     * @api {delete} /products/{sku}/images/{id_image} DeleteImage
     * @apiVersion 1.0.0
     * @apiGroup Products
     * @apiName DeleteImage
     * @apiDescription Permite apagar a imagem de um produto através do <code>id_image</code>
     * @apiUse HeaderExample

     * @apiHeaderExample {json} Url-Example:
     *    {
     *         "http://apilanlimp.wiperagency.com/api/v1/admin/products/VQG1vAhg4C8M7o4UCBQ1h3C7LIyTFn/images/2020Dzx9h0718uhSR5082405Imk6VK"
     *    }
     *
     * @apiParam {String} sku Código único do produto. Máximo 30 caracteres.
     * @apiParam {String} id_image Código único de imagem de um produto.
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
     * @apiError require Campos obrigatórios.
     * @apiError no_update O produto não pode ser atualizado, entre em contato com o administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_update"
     *     }
     *
    */
