<?php

    /**
     * @api {get} /products/{sku}/detail ProductDetail
     * @apiVersion 1.0.0
     * @apiGroup Commons
     * @apiName Detail
     * @apiDescription Retorna a informação completa de um produto associado a <code>sku</code>.
     * @apiUse HeaderCommonExample
     *
     * @apiParam {String} sku Código único do produto.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "response": {
     *           "name": "Cummings II",
     *           "sku": "8eQHFzsjKVA42v5UbISJBn9JXai4Sb",
     *           "html_description": "<html><head><title>Eum rerum possimus numquam laborum possimus sit velit aut labore ducimus ex.</title></head><body><form action=\"example.net\" method=\"POST\"><label for=\"username\">ea</label><input type=\"text\" id=\"username\"><label for=\"password\">voluptatum</label><input type=\"password\" id=\"password\"></form><a href=\"example.net\">Quibusdam labore maiores.</a><h2>Aut praesentium quia incidunt dolorem quis aliquid.</h2></body></html>\n",
     *           "html_short_description": "Beatae at molestias est fugit ea est cupiditate aut. Fugiat alias est pariatur voluptatibus. Rerum aut ea repudiandae rem officiis est.",
     *           "price": 123.95,
     *           "sale_price": 99.7,
     *           "categories": "category_2,category_4",
     *           "type": "type_a",
     *           "material": "material_a",
     *           "theme": "theme_c",
     *           "tags": null,
     *           "weight": 282.1758,
     *           "height": 255.0597,
     *           "width": 820,
     *           "length": 402,
     *           "title": "Pump Operators",
     *           "desc": null,
     *           "manufacturer": "Elevator Installer and Repairer",
                "variations": [
                    {
                        "cod": "U",
                        "sku": "U",
                        "price": 389,
                        "description": "Deleniti eius est nulla qui eaque consequatur.",
                        "ean13": "1000302225914",
                        "itf14": null
                    }
                ],
                "images": [
                    {
                        "id": "32202009e20200908083823kW",
                        "cod": null,
                        "sku": null,
                        "url": "apipandora.wiperagency.com/storage/images/D2020C090808380.jpg",
                        "height": "190",
                        "width": "236"
                    },
                    {
                        "id": "32202009e20200908083824kW",
                        "cod": null,
                        "sku": null,
                        "url": "apipandora.wiperagency.com/storage/images/D2020C090808381.jpg",
                        "height": "190",
                        "width": "236"
                    }
     *           ]
     *       }
     *   }
     *
     *
    */

    /**
     * @api {get} /products/list ProductsList
     * @apiVersion 1.0.0
     * @apiGroup Commons
     * @apiName ProductsList
     * @apiDescription Retorna uma lista do produtos por página, o valor por default é a página 1.
     * @apiUse HeaderCommonExample
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
                        "name": "Hessel",
                        "sku": "Q0N4aZrwbnDpDlXUve2lwMPCSPCktc",
                        "html_description": "<html><head><title>Deleniti eius est nulla qui eaque consequatur.</title></head><body><form action=\"example.com\" method=\"POST\"><label for=\"username\">quo</label><input type=\"text\" id=\"username\"><label for=\"password\">veritatis</label><input type=\"password\" id=\"password\"></form><b>Eos et dignissimos.</b>Et qui quia.<span>Neque.</span></body></html>\n",
                        "html_short_description": "Eos nam aspernatur accusamus qui quis fuga corrupti et. Minus velit aperiam dolorem voluptas. Ut vel alias asperiores molestiae. Eum quaerat nisi quia repellat voluptatem culpa commodi nesciunt.",
                        "price": 999.43,
                        "sale_price": 900.55,
                        "categories": "category_3,category_4",
                        "type": "type_a",
                        "material": "material_b",
                        "theme": "theme_c",
                        "tags": "tag_1,tag_2,tag_3",
                        "weight": 733.8737,
                        "height": 57.6663,
                        "width": 107,
                        "length": 962,
                        "title": "Answering Service",
                        "desc": null,
                        "manufacturer": "Clergy",
                        "variations": [
                            {
                                "cod": "U",
                                "sku": "U",
                                "price": 389,
                                "description": "Deleniti eius est nulla qui eaque consequatur.",
                                "ean13": "1000302225914",
                                "itf14": null
                            }
                        ],
                        "images": [
                            {
                                "id": "32202009e20200908083823kW",
                                "cod": null,
                                "sku": null,
                                "url": "apipandora.wiperagency.com/storage/images/D2020C090808380.jpg",
                                "height": "190",
                                "width": "236"
                            },
                            {
                                "id": "32202009e20200908083824kW",
                                "cod": null,
                                "sku": null,
                                "url": "apipandora.wiperagency.com/storage/images/D2020C090808381.jpg",
                                "height": "190",
                                "width": "236"
                            }
                        ]
                    },
                    {
                        "name": "Baumbach",
                        "sku": "fQmjrLx7TVcvt036vqK9KmYWlYs3Ne",
                        "html_description": "<html><head><title>Vitae adipisci et vel magni unde quibusdam fugiat et dolorum facere et soluta sunt.</title></head><body><form action=\"example.net\" method=\"POST\"><label for=\"username\">quidem</label><input type=\"text\" id=\"username\"><label for=\"password\">voluptatem</label><input type=\"password\" id=\"password\"></form><a href=\"example.net\">Maxime dolor quia facilis.</a><ul><li>Dolores voluptatem nihil.</li><li>Atque molestiae asperiores rerum.</li><li>Quia.</li><li>Aliquid aperiam amet.</li><li>Rerum.</li><li>Cum consequuntur.</li></ul></body></html>\n",
                        "html_short_description": "Debitis ut omnis sint non. Saepe animi totam aut voluptatem reprehenderit expedita. Aliquam placeat consequatur unde consequuntur quod ipsa et. Officia sunt fugiat nisi ut dolores rerum.",
                        "price": 456.28,
                        "sale_price": null,
                        "categories": "category_1,category_2",
                        "type": "type_d",
                        "material": "material_b",
                        "theme": "theme_c",
                        "tags": "tag_1,tag_2",
                        "weight": 88,
                        "height": 882.62,
                        "width": 28.645,
                        "length": 948,
                        "title": "Data Processing Equipment Repairer",
                        "desc": null,
                        "manufacturer": "Electrical Sales Representative",
                        "variations": [
                            {
                                "cod": "U",
                                "sku": "U",
                                "price": 389,
                                "description": "Deleniti eius est nulla qui eaque consequatur.",
                                "ean13": "1000302225914",
                                "itf14": null
                            }
                        ],
                        "images": [
                            {
                                "id": "32202009e20200908083824kW",
                                "cod": null,
                                "sku": null,
                                "url": "apipandora.wiperagency.com/storage/images/D2020C090808381.jpg",
                                "height": "190",
                                "width": "236"
                            }
                        ]
                    },
                ],
                "first_page_url": "http://apipandora.wiperagency.com/api/v1/products/list?page=1",
                "from": 1,
                "last_page": 100,
                "last_page_url": "http://apipandora.wiperagency.com/api/v1/products/list?page=100",
                "next_page_url": "http://apipandora.wiperagency.com/api/v1/products/list?page=2",
                "path": "http://apipandora.wiperagency.com/api/v1/products/list",
                "per_page": 10,
                "prev_page_url": null,
                "to": 10,
                "total": 1000
            }
        }

     *
    */
