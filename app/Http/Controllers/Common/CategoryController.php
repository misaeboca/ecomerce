<?php

namespace App\Http\Controllers\Common;

use App\Models\Common\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\ListRequest;
use App\Models\GlobalStatus;
use App\Models\Admin\Material;
use App\Models\Admin\Theme;

class CategoryController extends Controller
{

    /**
     * @api {get} /Categories/list List
     * @apiVersion 1.0.0
     * @apiGroup Payments
     * @apiName List
     * @apiDescription Get list Payments.
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
                    "name": "Category 1"
                },
                {
                    "id": "VE2020j0815x115228ai",
                    "name": "Category 2"
                }
            ]
        }
     *
     */
    public function getList(ListRequest $request)
    {
        //$materials = Material::select('name as title')->get();
        //$themes = Theme::select('name as title')->get();
        $categories = Category::whereNull('id_category')
        ->whereStatus(GlobalStatus::STATUS_ACTIVE)
        ->with('subCategories')
        ->get();

        /*foreach($categories as $category)
        {
            $category['submenu'] = [
                ['title' => 'tipo', 'submenu' => []],
                ['title' => 'materials', 'submenu' => $materials],
                ['title' => 'themes', 'submenu' => $themes],
            ];
        }*/
        return response()->json(['state' => 'success', 'response' => $categories], 200);
    }

    public function getMostVisited(ListRequest $request)
    {
        $categories = Category::get();
        return response()->json(['state' => 'success', 'response' => $categories], 200);
    }

}
