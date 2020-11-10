<?php

    /**
     * @api {get} /shares/list List
     * @apiGroup Shares
     * @apiName List
     * @apiDescription Get list Shares.
     * @apiUse HeaderExample
     *
     *
     * @apiParam {Number} [page] Get list of page <code>page</code> by default 1.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "response": {
     *           "current_page": 1,
     *           "data": [{
     *             "json" : {}
     *           }],
     *           "first_page_url": "http://flowdevs.com/api/v1/shares/list?page=1",
     *           "from": null,
     *           "last_page": 1,
     *           "last_page_url": "http://flowdevs.com/api/v1/shares/list?page=1",
     *           "next_page_url": null,
     *           "path": "http://flowdevs.com/api/v1/shares/list",
     *            "per_page": 10,
     *            "prev_page_url": null,
     *            "to": null,
     *            "total": 0
     *        }
     *    }
     *
     */


    /**
     * @api {post} /shares Add
     * @apiGroup Shares
     * @apiName Add
     * @apiDescription Permite registrar un nuevo Share.
     * @apiUse HeaderExample
     *
     * @apiParam {String} ushtc <code>Id</code> of <code>ShareType</code>.
     * @apiParam {String} json Informacion en formato json del <code>Share</code>. Max 5000 characters.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "create"
     *   }
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_create El Share no pudo ser creado.
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
     * @api {put} /shares/{ushc}/update Update
     * @apiGroup Shares
     * @apiName Update
     * @apiDescription Permite actualizar los datos de un Share.
     * @apiUse HeaderExample
     *
     * @apiParam {String} ushc <code>Id</code> del <code>Share</code>.
     * @apiParam {String} ushtc <code>Id</code> of <code>ShareType</code>.
     * @apiParam {String} json Informacion en formato json del <code>Share</code>. Max 5000 characters.
     *
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
     * @apiError no_update El Share no se pudo actualizar, contacte con el administrador.
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
     * @api {put} /shares/{ushc}/trash Trash
     * @apiGroup Shares
     * @apiName Trash
     * @apiDescription Permite enviar un produto a la papelera.
     * @apiUse HeaderExample
     *
     * @apiParam {String} [ushc] <code>Id</code> del <code>Share</code>.
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
     * @apiError no_update El Share no se pudo actualizar, contacte con el administrador.
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
     * @api {put} /shares/{ushc}/restore Restore
     * @apiGroup Shares
     * @apiName Restore
     * @apiDescription Permite restaurar un share enviado a la papelera.
     * @apiUse HeaderExample
     *
     * @apiParam {String} [ushc] <code>Id</code> del <code>Share</code>.
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
     * @apiError no_restore El Share no se pudo actualizar, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_restore"
     *     }
     *
     */
