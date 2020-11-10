<?php

    /**
     * @api {get} /admin/orders/{id_order}/detail Detail
     * @apiVersion 1.0.0
     * @apiGroup Orders
     * @apiName Detail
     * @apiDescription Retorna a informação completa de uma ordem associada ao <code>id_order</code>.
     * @apiUse HeaderExample
     *
     * @apiParam {String} id_order Código único de ordem. Máximo 30 caracteres.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": {
                "id": "L2020A0912104p2",
                "id_seller": null,
                "id_customer_address": "O2020t09121046l",
                "subtotal": "16007",
                "total": "16007",
                "status": "approved",
                "observations": null,
                "delivery_cost": "0",
                "delivery_notify": 0,
                "created_at": "2020-09-12T22:46:54.000000Z",
                "updated_at": "2020-09-12T22:47:00.000000Z",
                "payment_response_process": "[]",
                "delivery_response_process": null,
                "withdraw": null,
                "store": {
                    "id": "prueba",
                    "sigla": "PRU",
                    "name": "prueba",
                    "country": "BRA",
                    "city": "São Paulo",
                    "address": "Av. Regente Feijó, 1739 - Tatuapé (Loja OQ 147)",
                    "cep": "03342-000",
                    "email": "prueba@pandorastores.net",
                    "phone": "1155052164",
                    "logo": null,
                    "domain": "http://lanlimp.flexystore.com/prueba",
                    "coordinates": null,
                    "google_tag_manager": null,
                    "google_tag_manager_body": null,
                    "pickup": 0,
                    "created_at": "2020-09-05T19:47:17.000000Z",
                    "updated_at": "2020-09-05T19:47:17.000000Z"
                },
                "share": null,
                "delivery": null,
                "payment": {
                    "id": "braspag",
                    "name": "Braspag",
                    "slug": "braspag",
                    "created_at": "2020-09-02T22:38:40.000000Z",
                    "updated_at": "2020-09-02T22:38:40.000000Z"
                },
                "products": [
                    {
                        "cod": "u",
                        "product": {
                            "name": "ANEL ALIANÇA ETERNA",
                            "sku": "150163D",
                            "html_description": null,
                            "html_short_description": "ANEL ALIANÇA ETERNA",
                            "price": 10489,
                            "sale_price": null,
                            "categories": "ANÉIS",
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
                            "created_at": "2020-09-04T20:12:30.000000Z",
                            "updated_at": "2020-09-04T20:12:30.000000Z",
                            "deleted_at": null
                        },
                        "price": 10489,
                        "quantity": 1,
                        "task": 0,
                        "discount": 0,
                        "total": "10489"
                    }
                ],
                "customer": {
                    "id": "Q2020Z09121046Y",
                    "name": "Gary",
                    "lastname": "Romero",
                    "email": "garyromerob@gmail.com",
                    "cpf": "216354645",
                    "phone": "5812345678",
                    "created_at": "2020-09-12T22:46:54.000000Z",
                    "updated_at": "2020-09-12T22:46:54.000000Z"
                }
            }
        }
    *
    */

    /**
     * @api {get} /admin/Orders/list List
     * @apiVersion 1.0.0
     * @apiGroup Orders
     * @apiName List
     * @apiDescription Retorna as ordens que coincidam com o elemento buscado do parâmetro <code>search</code> de forma paginada.
     * @apiUse HeaderExample
     *
     * @apiParam {Number} [page] Parâmetro opcional para obter uma lista da página <code>page</code> por default esse valor é 1.
     * @apiParam {String} [search] Retornam os produtos que coincidam com o elemento buscado do parâmetro <code>search</code> de forma paginada.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
        "state": "success",
        "response": {
            "current_page": 1,
            "data": [
                {
                    "name": "ANEL ROSETM NÓ DO AMOR",
                    "sku": "180997CZ",
                    "html_description": null,
                    "html_short_description": "Anel ROSETM Nó do Amor",
                    "price": 969,
                    "sale_price": null,
                    "categories": "OURO,PRATA",
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
                    "created_at": "2020-09-04T20:16:08.000000Z",
                    "updated_at": "2020-09-04T20:16:08.000000Z",
                    "deleted_at": null,
                    "variations": [
                        {
                            "cod": "U",
                            "sku": "U",
                            "price": 969,
                            "description": "Anel ROSETM Nó do Amor",
                            "extra":"{\"produto\":\"180997CZ-50\",\"descricao\":\"ANEL ROSE N\Ó DO AMOR\",\"descricaoVitrine\":\"ANEL ROSETM N\Ó DO AMOR\",\"codTipo\":\"86\",\"descTipo\":\"ZIRCONIA CUBICA\",\"codGrupo\":\"25\",\"descGrupo\":\"AN\ÉIS\",\"codSubgrupo\":\"1\",\"descSubgrupo\":\"ANEL ACOMB\ÍNAVEL\",\"codColecao\":\"397\",\"descColecao\":\"2017 - Q1 - DROP 1\",\"codLinha\":\"32\",\"descLinha\":\"PANDORA TIMELESS\",\"codGriffe\":\"J\",\"descGriffe\":\"JEWELRY\",\"detalhe\":\"Anel ROSETM N\ó do Amor\",\"dataParaTransferencia\":\"2020-08-28T08:40:00\",\"diasBusca\":7,\"echoCadProdutosSku\":[{\"produto\":\"180997CZ-50\",\"corProduto\":\"03\",\"sku\":\"180997CZ-50031\",\"descricao\":\"ANEL ROSE N\Ó DO AMOR-CLEAR-SIZE 50\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"SIZE 50\",\"echoCadProdutosBarra\":[{\"produto\":\"180997CZ-50\",\"corProduto\":\"03\",\"sku\":\"180997CZ-50031\",\"descricao\":\"ANEL ROSE N\Ó DO AMOR-CLEAR-SIZE 50\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"SIZE 50\",\"codigoBarra\":\"5700302551051\"}]}]}",
                            "ean13": "5700302551051",
                            "itf14": null,
                            "created_at": "2020-09-04T20:16:08.000000Z",
                            "updated_at": "2020-09-04T20:16:08.000000Z",
                            "stock": null
                        },
                        {
                            "cod": "50",
                            "sku": "031",
                            "price": 969,
                            "description": "Anel ROSETM Nó do Amor",
                            "extra":"{\"produto\":\"180997CZ-50\",\"descricao\":\"ANEL ROSE N\Ó DO AMOR\",\"descricaoVitrine\":\"ANEL ROSETM N\Ó DO AMOR\",\"codTipo\":\"86\",\"descTipo\":\"ZIRCONIA CUBICA\",\"codGrupo\":\"25\",\"descGrupo\":\"AN\ÉIS\",\"codSubgrupo\":\"1\",\"descSubgrupo\":\"ANEL ACOMB\ÍNAVEL\",\"codColecao\":\"397\",\"descColecao\":\"2017 - Q1 - DROP 1\",\"codLinha\":\"32\",\"descLinha\":\"PANDORA TIMELESS\",\"codGriffe\":\"J\",\"descGriffe\":\"JEWELRY\",\"detalhe\":\"Anel ROSETM N\ó do Amor\",\"dataParaTransferencia\":\"2020-08-28T08:40:00\",\"diasBusca\":7,\"echoCadProdutosSku\":[{\"produto\":\"180997CZ-50\",\"corProduto\":\"03\",\"sku\":\"180997CZ-50031\",\"descricao\":\"ANEL ROSE N\Ó DO AMOR-CLEAR-SIZE 50\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"SIZE 50\",\"echoCadProdutosBarra\":[{\"produto\":\"180997CZ-50\",\"corProduto\":\"03\",\"sku\":\"180997CZ-50031\",\"descricao\":\"ANEL ROSE N\Ó DO AMOR-CLEAR-SIZE 50\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"SIZE 50\",\"codigoBarra\":\"5700302551051\"}]}]}",
                            "ean13": "5700302551051",
                            "itf14": null,
                            "created_at": "2020-09-04T20:16:08.000000Z",
                            "updated_at": "2020-09-04T20:16:08.000000Z",
                            "stock": null
                        },
                        {
                            "cod": "52",
                            "sku": "031",
                            "price": 969,
                            "description": "Anel ROSETM Nó do Amor",
                            "extra":"{\"produto\":\"180997CZ-52\",\"descricao\":\"ANEL ROSE N\Ó DO AMOR\",\"descricaoVitrine\":\"ANEL ROSETM N\Ó DO AMOR\",\"codTipo\":\"86\",\"descTipo\":\"ZIRCONIA CUBICA\",\"codGrupo\":\"25\",\"descGrupo\":\"AN\ÉIS\",\"codSubgrupo\":\"1\",\"descSubgrupo\":\"ANEL ACOMB\ÍNAVEL\",\"codColecao\":\"397\",\"descColecao\":\"2017 - Q1 - DROP 1\",\"codLinha\":\"32\",\"descLinha\":\"PANDORA TIMELESS\",\"codGriffe\":\"J\",\"descGriffe\":\"JEWELRY\",\"detalhe\":\"Anel ROSETM N\ó do Amor\",\"dataParaTransferencia\":\"2020-09-02T08:28:00\",\"diasBusca\":2,\"echoCadProdutosSku\":[{\"produto\":\"180997CZ-52\",\"corProduto\":\"03\",\"sku\":\"180997CZ-52031\",\"descricao\":\"ANEL ROSE N\Ó DO AMOR-CLEAR-SIZE 52\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"SIZE 52\",\"echoCadProdutosBarra\":[{\"produto\":\"180997CZ-52\",\"corProduto\":\"03\",\"sku\":\"180997CZ-52031\",\"descricao\":\"ANEL ROSE N\Ó DO AMOR-CLEAR-SIZE 52\",\"codCor\":\"03\",\"descCor\":\"CLEAR\",\"grade\":\"SIZE 52\",\"codigoBarra\":\"5700302551068\"}]}]}",
                            "ean13": "5700302551068",
                            "itf14": null,
                            "created_at": "2020-09-04T20:16:08.000000Z",
                            "updated_at": "2020-09-04T20:16:08.000000Z",
                            "stock": null
                        }
                    ],
                    "images": [
                        {
                            "id": "h2020q091406028",
                            "cod": null,
                            "sku": null,
                            "url": "http://apipandora.wiperagency.com/test.jpg",
                            "height": null,
                            "width": null,
                            "created_at": "2020-09-14T18:02:18.000000Z",
                            "updated_at": "2020-09-14T18:02:18.000000Z"
                        }
                    ]
                }
            ],
            "first_page_url": "http://apipandora.wiperagency.local/api/v1/admin/products/list?page=1",
            "from": 1,
            "last_page": 7,
            "last_page_url": "http://apipandora.wiperagency.local/api/v1/admin/products/list?page=7",
            "next_page_url": "http://apipandora.wiperagency.local/api/v1/admin/products/list?page=2",
            "path": "http://apipandora.wiperagency.local/api/v1/admin/products/list",
            "per_page": 10,
            "prev_page_url": null,
            "to": 10,
            "total": 62
        }
    */



