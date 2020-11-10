<?php

    /**
     * @api {get} /Orders/list List
     * @apiGroup Orders
     * @apiName List
     * @apiDescription Get list Orders.
     * @apiUse HeaderExample
     *
     *
     * @apiParam {Number} [page] Parámetro opcional para obtener el listado de la pagina <code>page</code> por defecto este valor es 1.
     * @apiParam {String} [search] Retorna las órdenes que coincidan con el elemento buscado del parámetro <code>search</code> de forma paginada.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "response": {
     *           "current_page": 1,
     *           "data": [
     *               {
     *                   "total": 4372389,
     *                   "status": "reject",
     *                   "observations": "Expedita minus tenetur dolorem eligendi natus provident. Quod sint unde qui ea. Blanditiis sint ut qui. Quo quia tempore vero optio dignissimos atque.",
     *                   "created_at": "2020-07-19T03:19:38.000000Z",
     *                   "updated_at": "2020-07-19T03:19:38.000000Z",
     *                   "name": "Andreanne Torphy",
     *                   "lastname": "Lehner",
     *                   "email": "mills.wilburn@hotmail.com",
     *                   "id_order": "w9Vx6AehsstapKKq5egrlTHLmiTfWG",
     *                   "store": {
     *                       "name": "Dr. Jovani Cormier",
     *                       "country": "Indonesia",
     *                       "usc": "Sl1eboxkTTS0G70zjkYuuBLvHeH0sF",
     *                       "email": "carolina.nikolaus@little.biz",
     *                       "whatsapp": "+7833409323976",
     *                       "logo": "https://lorempixel.com/640/480/?63177"
     *                   },
     *                   "share": null,
     *                   "delivery": {
     *                       "id": "Ntr4AoGh461O738NiVb5Q9bjxuGYbM",
     *                       "name": "Fedex"
     *                   },
     *                   "payment": {
     *                       "upc": "0xuDY9c6ehc8scEy9k0RBqjbgXZmtm",
     *                       "name": "Paypal"
     *                   },
     *                   "products": [
     *                       {
     *                           "price": 100.32,
     *                           "cant": 3,
     *                           "task": 0,
     *                           "discount": 0,
     *                           "total": 300.96,
     *                           "product": {
     *                               "name": "Ian Bergnaum",
     *                               "sku": "uhcx2aDXUzduAcQGffPIEgnxQ0bumP",
     *                               "html_description": "<html><head><title>Vel velit illo est incidunt molestiae quis et.</title></head><body><form action=\"example.com\" method=\"POST\"><label for=\"username\">tempora</label><input type=\"text\" id=\"username\"><label for=\"password\">reprehenderit</label><input type=\"password\" id=\"password\"></form><ul><li>Fugit et perspiciatis.</li><li>Ullam qui.</li><li>Vel laudantium dolorem eos.</li><li>Qui sed.</li><li>Et et neque facere.</li></ul></body></html>\n",
     *                               "html_short_description": "Accusantium possimus quas quia. Labore consequuntur recusandae odio sint. Molestiae ratione fugiat non repellendus debitis officiis distinctio odio.",
     *                               "sale_price": 300.32,
     *                               "categories": null,
     *                               "type": "type_d",
     *                               "material": "material_c",
     *                               "theme": "theme_d",
     *                               "tags": null,
     *                               "weight": 89.7931,
     *                               "height": 517,
     *                               "width": 612.1279,
     *                               "length": 683,
     *                               "title": "Brazer",
     *                               "desc": null,
     *                               "manufacturer": "Dancer",
     *                               "created_at": "2020-07-19T03:19:28.000000Z",
     *                               "updated_at": "2020-07-19T03:19:28.000000Z"
     *                           }
     *                       },
     *                       {
     *                           "price": 258.51,
     *                           "cant": 1,
     *                           "task": 0,
     *                           "discount": 0,
     *                           "total": 258.51,
     *                           "product": {
     *                               "name": "Carmelo Thiel",
     *                               "sku": "rZ7bLNV8lJ09QDJF7T1uWctO3uuaja",
     *                               "html_description": "<html><head><title>Sed tenetur.</title></head><body><form action=\"example.net\" method=\"POST\"><label for=\"username\">omnis</label><input type=\"text\" id=\"username\"><label for=\"password\">est</label><input type=\"password\" id=\"password\"></form><b>Qui amet fuga aut.</b><ul><li>Laudantium similique.</li></ul><table><thead><tr><th>Saepe blanditiis et.</th><th>Dolorem.</th><th>Architecto repellendus voluptatem modi.</th><th>Tenetur molestiae deserunt itaque adipisci.</th><th>Corporis ea.</th><th>Perspiciatis voluptas.</th></tr></thead><tbody><tr><td>Nam labore voluptas.</td><td>Alias blanditiis sed rerum.</td><td>Qui cumque esse dolorem voluptatem temporibus.</td><td>Adipisci in eum totam ut totam.</td><td>Dolor vel est et eligendi aut autem veniam aut delectus eos nobis.</td><td>Ut assumenda ad aut velit qui assumenda excepturi laborum.</td></tr><tr><td>Repudiandae doloribus et quo ex.</td><td>Incidunt est.</td><td>Delectus ut.</td><td>Iusto architecto fuga fuga mollitia possimus id aliquam.</td><td>Non nam at incidunt dicta tempore ut cupiditate.</td><td>Ducimus similique eum dolores qui.</td></tr><tr><td>Deleniti.</td><td>Et eum ea aut voluptas.</td><td>Dolor aut sequi fugit doloribus et non impedit quis et aperiam ut quisquam repellat.</td><td>Repudiandae vel tempora.</td><td>Id occaecati quos et numquam cum.</td><td>Est et qui doloremque.</td></tr><tr><td>Rerum fugiat expedita quas.</td><td>Aut voluptatem ipsum voluptatem repellat minus nihil laborum est itaque qui consequatur.</td><td>Sint qui et ducimus.</td><td>Sit quo ex porro quia quia aut.</td><td>Qui expedita iure.</td><td>Fugiat veniam et iure voluptatum quia beatae illum voluptas vitae dignissimos ut vel consequatur facilis.</td></tr><tr><td>Eveniet nesciunt et.</td><td>Adipisci ut eveniet dignissimos velit.</td><td>Sunt voluptates.</td><td>Adipisci aut quia ut perferendis nisi cumque.</td><td>Assumenda nemo ut doloremque quo.</td><td>Quibusdam et dolorem voluptatibus voluptatem sit.</td></tr></tbody></table></body></html>\n",
     *                               "html_short_description": "Commodi nihil optio ut aliquid possimus consequuntur inventore. Sint sunt quam magni animi aut omnis dicta. Possimus consequatur molestiae corrupti. Dolorem quam iusto tempora quo consequatur non.",
     *                               "sale_price": null,
     *                               "categories": null,
     *                               "type": "type_a",
     *                               "material": "material_a",
     *                               "theme": "theme_c",
     *                               "tags": null,
     *                               "weight": 816.4422,
     *                               "height": 854.7635,
     *                               "width": 587.5567,
     *                               "length": 512,
     *                               "title": "Surgical Technologist",
     *                               "desc": null,
     *                               "manufacturer": "Loan Interviewer",
     *                               "created_at": "2020-07-19T03:19:28.000000Z",
     *                               "updated_at": "2020-07-19T03:19:28.000000Z"
     *                           }
     *                       }
     *                   ]
     *               },
     *               {
     *                   "total": 6508114.01,
     *                   "status": "pending",
     *                   "observations": "Eveniet reprehenderit assumenda excepturi. Molestiae in occaecati beatae dolores quisquam recusandae consectetur modi. Dolorem saepe voluptatum perferendis id. Fuga autem illum commodi aut.",
     *                   "created_at": "2020-07-19T03:19:38.000000Z",
     *                   "updated_at": "2020-07-19T03:19:38.000000Z",
     *                   "name": "Rachel Koelpin",
     *                   "lastname": "Ruecker",
     *                   "email": "aklein@bartell.org",
     *                   "id_order": "rqp3Qi5yOYXDf47iYdeULUFOCgODPi",
     *                   "store": {
     *                       "name": "Lina Cole MD",
     *                       "country": "Uganda",
     *                       "usc": "tcPaSDIGT89BmUdgNR9XqQRXTRlzUC",
     *                       "email": "gwatsica@yahoo.com",
     *                       "whatsapp": "+1246852324522",
     *                       "logo": "https://lorempixel.com/640/480/?81165"
     *                   },
     *                   "share": null,
     *                   "delivery": {
     *                       "id": "QAevLJoDR9pmWIf4WbnChMuJT5Pumn",
     *                       "name": "Fedex"
     *                   },
     *                   "payment": {
     *                       "upc": "d9dGRBraJB5jVaUzEpz7emDN373Vwi",
     *                       "name": "Paypal"
     *                   },
     *                   "products": [
     *                       {
     *                           "price": 210.1,
     *                           "cant": 1,
     *                           "task": 0,
     *                           "discount": 0,
     *                           "total": 1206708399.43,
     *                           "product": {
     *                               "name": "Carlee Bradtke",
     *                               "sku": "Kmw0jhjFBMdWGNWw8H9dvYODjKXcbt",
     *                               "html_description": "<html><head><title>Dolores.</title></head><body><form action=\"example.net\" method=\"POST\"><label for=\"username\">neque</label><input type=\"text\" id=\"username\"><label for=\"password\">autem</label><input type=\"password\" id=\"password\"></form><span>Nobis suscipit possimus aut tenetur commodi quasi esse perspiciatis error.</span></body></html>\n",
     *                               "html_short_description": "Repudiandae nobis natus magni eos recusandae minima. Nihil molestiae autem incidunt at. Accusamus modi deleniti cum omnis enim. Ipsa voluptate ut similique hic.",
     *                               "sale_price": 210.1,
     *                               "categories": null,
     *                               "type": "type_a",
     *                               "material": "material_b",
     *                               "theme": "theme_a",
     *                               "tags": null,
     *                               "weight": 295.4389,
     *                               "height": 65.7517,
     *                               "width": 989.3929,
     *                               "length": 463,
     *                               "title": "Retail Sales person",
     *                               "desc": null,
     *                               "manufacturer": "Woodworker",
     *                               "created_at": "2020-07-19T03:19:28.000000Z",
     *                               "updated_at": "2020-07-19T03:19:28.000000Z"
     *                           }
     *                       },
     *                       {
     *                           "price": 99.15,
     *                           "cant": 1,
     *                           "task": 0,
     *                           "discount": 0,
     *                           "total": 1921608118.32,
     *                           "product": {
     *                               "name": "Odell Yost PhD",
     *                               "sku": "RQQc0auIh8rfAsjLtzROCcowEmBcl2",
     *                               "html_description": "<html><head><title>Repudiandae autem autem rerum.</title></head><body><form action=\"example.org\" method=\"POST\"><label for=\"username\">natus</label><input type=\"text\" id=\"username\"><label for=\"password\">alias</label><input type=\"password\" id=\"password\"></form><p>Et natus error vero et dolore omnis debitis alias accusantium deleniti.</p><h3>Assumenda ex sed voluptates culpa earum quidem.</h3></body></html>\n",
     *                               "html_short_description": "Accusantium numquam magnam laboriosam dolor quia facilis. Quis asperiores non ducimus nemo. Iusto aspernatur molestiae expedita earum. Doloremque tenetur ea eaque alias neque est.",
     *                               "sale_price": 99.15,
     *                               "categories": null,
     *                               "type": "type_b",
     *                               "material": "material_b",
     *                               "theme": "theme_b",
     *                               "tags": null,
     *                               "weight": 659.2314,
     *                               "height": 420.5933,
     *                               "width": 351.276,
     *                               "length": 350,
     *                               "title": "Insurance Sales Agent",
     *                               "desc": null,
     *                               "manufacturer": "Aircraft Cargo Handling Supervisor",
     *                               "created_at": "2020-07-19T03:19:28.000000Z",
     *                               "updated_at": "2020-07-19T03:19:28.000000Z"
     *                           }
     *                       }
     *                   ]
     *               },
     *           ],
     *           "first_page_url": "http://flowdevs.com/api/v1/orders/list?page=1",
     *           "from": 1,
     *           "last_page": 30,
     *           "last_page_url": "http://flowdevs.com/api/v1/orders/list?page=30",
     *           "next_page_url": "http://flowdevs.com/api/v1/orders/list?page=2",
     *           "path": "http://flowdevs.com/api/v1/orders/list",
     *           "per_page": 10,
     *           "prev_page_url": null,
     *           "to": 10,
     *           "total": 300
     *       }
     *   }
     *
    */
