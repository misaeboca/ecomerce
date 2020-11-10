<?php

/**
     * @apiDefine HeaderCommonExample
     * @apiHeaderExample {json} Header-Example:
     *    {
     *      "Content-Type": "application/json"
     *    }
*/

/**
     * @apiDefine HeaderExample
     * @apiHeaderExample {json} Header-Example:
     *    {
     *      "Content-Type": "application/json",
     *      "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ19.eyJpc3MiOiJodHRwL3YxXC9hdXFuZXRhLmxvY2FsXC9hcGlcL3YxXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE1ODY2NDUyNjUsImV4cCI6MTU4NjY0ODg2NSwibmJmIjoxNTg2NjQ1MjY1LCJqdGkiOiJqUUIzdElTdWNvdFZYQ0hYIiwic3ViIjoxMDIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.PZCZrKxOGpDGkTa-ZZCA9wX3tkn8IjQFvdcDekR-NP0"
     *    }
*/

// PRODUCTS TEMPLATE

/**
     * @apiDefine ProductParams
     * @apiParam {String} name Nome do produto. Máximo 255 caracteres.
     * @apiParam {String} sku Código único do produto. Máximo 30 caracteres.
     * @apiParam {String} categories Categorias do produto. Exemplo: category_1,category_2,...,category_n. Máximo 500 caracteres.
     * @apiParam {Numeric} price Preço do produto.
     * @apiParam {Numeric} [sale_price] Preço de venda do produto.
     * @apiParam {String} [type] Tipo do produto. Máximo 500 caracteres.
     * @apiParam {String} [material] Material do produto. Máximo 500 caracteres.
     * @apiParam {String} [theme] Tema do produto. Máximo 500 caracteres.
     * @apiParam {String} [html_description] Descrição do produto. Máximo 5.000 caracteres.
     * @apiParam {String} [html_short_description] Descrição curta do produto. Máximo 500 caracteres.
     * @apiParam {String} [tags] Etiquetas do produto. Exemplo: tag_1,tag_1_2,...,tag_1_n. Máximo 400 caracteres.
     * @apiParam {Numeric} [weight] Peso do produto.
     * @apiParam {Numeric} [height] Altura do produto.
     * @apiParam {Numeric} [width] Largura do produto.
     * @apiParam {Numeric} [length] Comprimento do produto.
     * @apiParam {String} [title] Título do produto para <code>SEO</code>. Máximo 500 caracteres.
     * @apiParam {String} [desc] Descrição do produto para <code>SEO</code>. Máximo 500 caracteres.
     * @apiParam {String} [manufacturer] Fabricante do produto. Máximo 500 caracteres.
*/

// STORES TEMPLATE

/**
     * @apiDefine StoreParams
     * @apiParam {String} usc <code>Unique Code Store</code>.
     * @apiParam {String} name Name of <code>Store</code>.
     * @apiParam {String} [country] Country of <code>Store</code>.
     * @apiParam {String} [email] Email of <code>Store</code>.
     * @apiParam {String} [whatsapp] Whatsapp of <code>Store</code>.
     * @apiParam {String} [logo] Logo of <code>Store</code>.
     * @apiParam {String} [domain] Domain of <code>Store</code>.
     * @apiParam {String} [sigla] Sigla of <code>Store</code>.
     * @apiParam {String} [google_tag_manager] Google Tag Manager of <code>Store</code>.
     * @apiParam {String} [pixel_facebook] Pixel Facebook of <code>Store</code>.
     * @apiParam {String} Loggi.user Loggi user of <code>Store</code>.
     * @apiParam {String} Loggi.password Loggi password of <code>Store</code>.
     * @apiParam {String} Loggi.apiKey Loggi Api key of <code>Store</code>.
     * @apiParam {String} Loggi.distance Loggi Max distance of <code>Store</code>.
*/

// ORDERS TEMPLATE

/**
     * @apiDefine OrderParams
     * @apiParam {String} usc <code>Unique Code Store</code>.
     * @apiParam {String} customer.name Name of <code>Customer</code>.
     * @apiParam {String} customer.lastname lastname of <code>Customer</code>.
     * @apiParam {String} customer.email email of <code>Customer</code>.
     * @apiParam {String} customer.phone phone of <code>Customer</code>.
     * @apiParam {String} customer.cpf cpf of <code>Customer</code>.
     * @apiParam {String} customer.deliveryAddress Name of <code>Customer</code>.
     *
     * @apiParam {String} [country] Country of <code>Store</code>.
*/
