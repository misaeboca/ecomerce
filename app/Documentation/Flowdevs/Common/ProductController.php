<?php


    /**
     * @api {get} /products/{sku}/detail ProductDetail
     * @apiGroup Commons
     * @apiName ProductDetail
     * @apiDescription Retorna la informacion completa de un producto asociado al <code>sku</code>.
     * @apiUse HeaderCommonExample
     *
     * @apiParam {String} sku codigo unico de producto.
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
     *           "status": "trash",
     *           "images": [
     *               {
     *                   "url": "https://lorempixel.com/640/480/?57604",
     *                   "id": "jqRnC1XsvTvyJWkpg9x93R9i83ebpX"
     *               },
     *               {
     *                   "url": "https://lorempixel.com/640/480/?96069",
     *                   "id": "N0k85pUR1khU3Y57gdrK2snbw6C8P3"
     *               }
     *           ]
     *       }
     *   }
     *
    */

    /**
     * @api {get} /products/list Products
     * @apiGroup Commons
     * @apiName Products
     * @apiDescription Retorna un listado de productos paginados, el valor por defecto es la página 1.
     * @apiUse HeaderCommonExample
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
                        "name": "Hessel",
                        "sku": "Q0N4aZrwbnDpDlXUve2lwMPCSPCktc",
                        "html_description": "<html><head><title>Deleniti eius est nulla qui eaque consequatur.</title></head><body><form action=\"example.com\" method=\"POST\"><label for=\"username\">quo</label><input type=\"text\" id=\"username\"><label for=\"password\">veritatis</label><input type=\"password\" id=\"password\"></form><b>Eos et dignissimos.</b>Et qui quia.<span>Neque.</span></body></html>\n",
                        "html_short_description": "Eos nam aspernatur accusamus qui quis fuga corrupti et. Minus velit aperiam dolorem voluptas. Ut vel alias asperiores molestiae. Eum quaerat nisi quia repellat voluptatem culpa commodi nesciunt.",
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
                        "status": "active",
                        "images": [
                            {
                                "url": "https://lorempixel.com/640/480/?94076",
                                "id": "xR2jcUXrKaiCrTZrr8AQO5jhRR4xfY",
                            },
                            {
                                "url": "https://lorempixel.com/640/480/?69268",
                                "id": "6JNpxjP0eKWu0qsuD5efjcGT0liglQ",
                            }
                        ]
                    },
                    {
                        "name": "Baumbach",
                        "sku": "fQmjrLx7TVcvt036vqK9KmYWlYs3Ne",
                        "html_description": "<html><head><title>Vitae adipisci et vel magni unde quibusdam fugiat et dolorum facere et soluta sunt.</title></head><body><form action=\"example.net\" method=\"POST\"><label for=\"username\">quidem</label><input type=\"text\" id=\"username\"><label for=\"password\">voluptatem</label><input type=\"password\" id=\"password\"></form><a href=\"example.net\">Maxime dolor quia facilis.</a><ul><li>Dolores voluptatem nihil.</li><li>Atque molestiae asperiores rerum.</li><li>Quia.</li><li>Aliquid aperiam amet.</li><li>Rerum.</li><li>Cum consequuntur.</li></ul></body></html>\n",
                        "html_short_description": "Debitis ut omnis sint non. Saepe animi totam aut voluptatem reprehenderit expedita. Aliquam placeat consequatur unde consequuntur quod ipsa et. Officia sunt fugiat nisi ut dolores rerum.",
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
                        "status": "active",
                        "images": [
                            {
                                "url": "https://lorempixel.com/640/480/?99783",
                                "id": "fEMPaZmTMngzgsWM10Qd6oMIz4NZJZ",
                            }
                        ]
                    },
                ],
                "first_page_url": "http://flowdevs.com/api/v1/products/list?page=1",
                "from": 1,
                "last_page": 100,
                "last_page_url": "http://flowdevs.com/api/v1/products/list?page=100",
                "next_page_url": "http://flowdevs.com/api/v1/products/list?page=2",
                "path": "http://flowdevs.com/api/v1/products/list",
                "per_page": 10,
                "prev_page_url": null,
                "to": 10,
                "total": 1000
            }
        }
     *
     * @apiSampleRequest http://flowdevs.com/api/v1/products/list/
    */

    /**
     * @api {get} /products/listFeatureds ProductsFeatureds
     * @apiGroup Commons
     * @apiName ProductsFeatureds
     * @apiDescription Retorna un listado de productos destacados, agrupados por su <code>group</code> y paginados, el valor por defecto es la página 1.
     * @apiUse HeaderCommonExample
     *
     * @apiSuccessExample Success-Response:
     * HTTP/1.1 200 OK
        {
            "state": "success",
            "response": {
                "2": [
                    {
                        "name": "Pulsera en Plata con Cierre PANDORA con cierre de barril",
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
                        "usc": "4k20209FOu0816d5awc122506cpL39",
                        "group": "2",
                        "images": []
                    },
                    {
                        "name": "Pulsera2 en Plata con Cierre PANDORA con cierre de barril",
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
                        "usc": "4k20209FOu0816d5awc122506cpL39",
                        "group": "2",
                        "images": []
                    }
                ],
                "3": [
                    {
                        "name": "Pulsera en Plata con Cierre PANDORA con cierre de barril",
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
                        "usc": "4k20209FOu0816d5awc122506cpL39",
                        "group": "3",
                        "images": []
                    }
                ],
                "1": [
                    {
                        "name": "Pulsera2 en Plata con Cierre PANDORA con cierre de barril",
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
