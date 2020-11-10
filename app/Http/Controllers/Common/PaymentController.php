<?php

namespace App\Http\Controllers\Common;

use App\Models\Common\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\ListRequest;
use App\Models\Common\ClientPayment;

class PaymentController extends Controller
{

    /**
     * @api {get} /Payments/list List
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
                    "name": "Braspag",
                    "upc": "1J2020y0815I1152289g"
                },
                {
                    "name": "Paypal",
                    "upc": "VE2020j0815x115228ai"
                }
            ]
        }
     *
     */
    public function getList(ListRequest $request)
    {
        $data = $request->all();

        $payments = Payment::select(['payments.id', 'payments.name'])->join('clients_payments as cp', 'cp.id_payment', '=', 'payments.id')
        ->where('cp.status', '=', ClientPayment::STATUS_ACTIVE)
        //->where('cp.id_client', '=', '')
        ->orderBy('payments.id_number', $data['sort'])
        ->get();

        return response()->json(['state' => 'success', 'response' => $payments], 200);
    }

}
