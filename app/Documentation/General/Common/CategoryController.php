<?php


    /**
     * @api {get} /categories/list CategoriesList
     * @apiVersion 1.0.0
     * @apiGroup Commons
     * @apiName List
     * @apiDescription Retorna el listado categorias y subcategorias.
     * @apiUse HeaderExample
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": [
                {
                    "id": "R2020g091401235",
                    "name": "aaa",
                    "slug": "aaa",
                    "sub_categories": [
                        {
                            "id": "g2020V09140123p",
                            "name": "bbb",
                            "slug": "bbb",
                            "sub_categories": [
                                {
                                    "id": "O2020z09140123W",
                                    "name": "ddd",
                                    "slug": "ddd",
                                    "sub_categories": [
                                        {
                                            "id": "g2020A0914012312",
                                            "name": "eee",
                                            "slug": "eee",
                                            "sub_categories": []
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            "id": "g2020A091401231",
                            "name": "ccc",
                            "slug": "ccc",
                            "sub_categories": []
                        }
                    ]
                },
                {
                    "id": "r2020w091401231",
                    "name": "fff",
                    "slug": "fff",
                    "sub_categories": []
                },
                {
                    "id": "g2020A09140123W",
                    "name": "fff",
                    "slug": "fff",
                    "sub_categories": []
                }
            ]
        }
    *
    */
