<?php

namespace App\Http\Controllers\Common;

use App\Models\Common\Delivery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\ListRequest;
use App\Models\Common\ClientDelivery;

class DeliveryController extends Controller
{

    /**
     * @api {get} /Deliveries/list List
     * @apiVersion 1.0.0
     * @apiGroup Deliveries
     * @apiName List
     * @apiDescription Get list Deliveries.
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
                    "name": "Loggi",
                    "id": "VlgZ7aQPqA"
                },
                {
                    "name": "Champlin",
                    "id": "Tag5X0NV1O"
                },
                {
                    "name": "Elnora",
                    "id": "NAjreP7UQr"
                },
                {
                    "name": "Ethyl",
                    "id": "RLHwK78KFo"
                }
            ]
        }
     */
    public function getList(ListRequest $request)
    {
        $data = $request->all();

        $payments = Delivery::select(['deliveries.id', 'deliveries.name', 'deliveries.opening', 'deliveries.closing'])->join('clients_deliveries as cd', 'cd.id_delivery', '=', 'deliveries.id')
        ->where('cd.status', '=', ClientDelivery::STATUS_ACTIVE)
        ->orderBy('deliveries.id_number', $data['sort'])
        ->get();

        return response()->json(['state' => 'success', 'response' => $payments], 200);
    }

}
