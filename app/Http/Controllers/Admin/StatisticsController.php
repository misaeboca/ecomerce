<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\ListRequest;
use App\Models\Admin\Order;
use App\Models\Admin\OrderProduct;
use App\Models\Admin\StoreClick;

class StatisticsController extends Controller
{

    public function getClickList(ListRequest $request)
    {
        $data = $request->all();
        $clicksVisit = StoreClick::whereDate('register_date', '>=', $data['from'])->whereDate('register_date', '<=', $data['until']);

        if(!$data['user']->hasRole(['root', 'master']))
        {
            $clicksVisit = $clicksVisit->whereIdStore($data['user']->store_user->id_store)->whereIdSeller($data['user']->code)->get();
        }
        else {
            $clicksVisit = $clicksVisit->get();
        }

        return response()->json(['state' => 'success', 'response' => $clicksVisit->groupBy('register_date')->sort()], 200);
    }

    public function getOrdersList(ListRequest $request)
    {
        $data = $request->all();
        $orders = Order::whereDate('register_date', '>=', $data['from'])->whereDate('register_date', '<=', $data['until']);

        if(!$data['user']->hasRole(['root', 'master']))
        {
            $orders = $orders->whereIdStore($data['user']->store_user->id_store)->whereIdSeller($data['user']->code)->get();
        }
        else {
            $orders = $orders->get();
        }

        return response()->json(['state' => 'success', 'response' => $orders->groupBy('register_date')->sort()], 200);
    }

    public function getProductsList(ListRequest $request)
    {
        $data = $request->all();
        $orders = Order::whereDate('orders.register_date', '>=', $data['from'])
        ->whereDate('orders.register_date', '<=', $data['until'])
        ->join('orders_products as op', 'op.id_order', '=', 'orders.id');


        if(!$data['user']->hasRole(['root', 'master']))
        {
            $orders = $orders->where('orders.id_store', '=', $data['user']->store_user->id_store)->where('orders.id_seller', '=', $data['user']->code)->get();
        }
        else {
            $orders = $orders->get();
        }
        $orders = $orders->groupBy('id')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort();
        $res = [];
        foreach($orders as $k => $order)
        {
            $res[$k] =  $order;
        }

        return response()->json(['state' => 'success', 'response' => $res], 200);
    }

}
