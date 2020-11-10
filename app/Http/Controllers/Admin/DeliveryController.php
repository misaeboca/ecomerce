<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Deliveries\Loggi\Loggi;
use App\Deliveries\MainDeliveryMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Delivery\ListRequest;
use App\Http\Requests\Admin\Delivery\NotifyRequest;
use App\Models\Admin\CustomerAddress;
use App\Models\Admin\Order;
use App\Models\Admin\Store;

class DeliveryController extends Controller
{

    /**
     * @api {get} /admin/deliveries/list List
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
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
        {
            "state": "success",
            "response": [
                {
                    "name": "Loggi",
                    "id": "VlgZ7aQPqA",
                    "created_at": "2020-08-15T23:52:28.000000Z",
                    "updated_at": "2020-08-15T23:52:28.000000Z",
                    "slug": "loggi"
                },
                {
                    "name": "Champlin",
                    "id": "Tag5X0NV1O",
                    "created_at": "2020-08-15T23:52:28.000000Z",
                    "updated_at": "2020-08-15T23:52:28.000000Z",
                    "slug": "arnold-champlin"
                },
                {
                    "name": "Elnora",
                    "id": "NAjreP7UQr",
                    "created_at": "2020-08-15T23:52:28.000000Z",
                    "updated_at": "2020-08-15T23:52:28.000000Z",
                    "slug": "prof.-elnora-armstrong-iv"
                },
                {
                    "name": "Ethyl",
                    "id": "RLHwK78KFo",
                    "created_at": "2020-08-15T23:52:28.000000Z",
                    "updated_at": "2020-08-15T23:52:28.000000Z",
                    "slug": "ethyl-west-dvm"
                }
            ]
        }
     */
    public function getList(ListRequest $request)
    {
        $data = $request->all();
        $payments = Delivery::get();
        return response()->json(['state' => 'success', 'response' => $payments], 200);
    }

    public function notify(NotifyRequest $request)
    {
        $data = $request->all();
        $order = Order::whereId($data['id_order'])->with('customer')->first();


        switch($order->id_delivery)
        {
            case MainDeliveryMethod::DELIVERY_LOGGI:
                DB::beginTransaction();
                $store = Store::whereId($order->id_store)->first();
                $loggi = new Loggi($store->loggi->user, $store->loggi->api_key, $store->loggi->shop, $store->loggi_address, $store->loggi->distance);

                $customerDeliveryAddress = CustomerAddress::whereId($order->id_customer_address)->first();

                $address = $customerDeliveryAddress['street']  . ' ' .
                        $customerDeliveryAddress['number']   . ', ';

                if(isset($customerDeliveryAddress['complement']))
                {
                    $address .= $customerDeliveryAddress['complement']  . ', ' ;
                }

                $address .= $customerDeliveryAddress['district'] . ' - ' .
                        $customerDeliveryAddress['city'] . ' ' .
                        $customerDeliveryAddress['state'] . ' ' .
                        $customerDeliveryAddress['cep'] . ', Brasil';

                $res = $loggi->notifyDelivery([
                    'tracking_key' => $order->id,
                    'full_name' => $order->customer->name . ' ' . $order->customer->lastname,
                    'phone' => $order->customer->phone,
                    'address' => $address
                ]);

                try {
                    if($res->data->createOrder->success)
                    {
                        $res2 = $loggi->trackingUrl($res->data->createOrder->orders[0]->pk);
                        $order->update([
                            'delivery_notify' => 1,
                            'delivery_response' => json_encode($res),
                            'delivery_response_process' => json_encode(
                                [
                                    "pk" => $res->data->createOrder->orders[0]->pk,
                                    "status" => $res->data->createOrder->orders[0]->packages[0]->status,
                                    'tracking_url' =>$res2->data->retrieveOrderWithPk->packages[0]->shareds->edges[0]->node->trackingUrl
                                ]),
                            'nota_fiscal' => $data['nota']
                        ]);
                        DB::commit();
                        return response()->json(['state' => 'success', 'response' => ['data' => $res2->data->retrieveOrderWithPk->packages[0]->shareds->edges[0]->node->trackingUrl]], 200);
                    }
                    return response()->json(['state' => 'success', 'response' => false], 200);
                } catch (\Exception $e)
                {
                    DB::rollback();
                    logError('DeliveryController@notify: ' . $e->getMessage());
                    return response()->json(['state' => 'fail', 'msg' => 'not_notify'], 401);
                }

            break;
        }

    }
}
