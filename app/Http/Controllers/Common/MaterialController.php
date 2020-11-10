<?php

namespace App\Http\Controllers\Common;

use App\Models\Common\Material;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\ListRequest;

class MaterialController extends Controller
{

    /**
     * @api {get} /Categories/list List
     * @apiVersion 1.0.0
     * @apiGroup Payments
     * @apiName List
     * @apiDescription Get list Materials.
     *
     * @apiHeaderExample {json} Header-Example:
     *    {
     *      "Content-Type": "application/json"
     *    }
     *
     *
     * @apiParam {Number} [page] Parámetro opcional para obtener el listado de la pagina <code>page</code> por defecto este valor es 1.
     * @apiParam {String} [search] Retorna las órdenes que coincidan con el elemento buscado del parámetro <code>search</code> de forma paginada.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": [
                {
                    "id": "1J2020y0815I1152289g",
                    "name": "Material 1"
                },
                {
                    "id": "VE2020j0815x115228ai",
                    "name": "Material 2"
                }
            ]
        }
     *
     */
    public function getList(ListRequest $request)
    {
        $materials = Material::select('name as title', 'slug')->get();
        return response()->json(['state' => 'success', 'response' => $materials], 200);
    }


    public function getProducts(ListRequest $request)
    {
        $categories = Material::get();
        return response()->json(['state' => 'success', 'response' => $categories], 200);
    }

}
