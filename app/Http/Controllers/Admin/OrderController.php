<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Admin\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\ListRequest;
use App\Http\Requests\Admin\Order\UpdateRequest;
use App\Http\Requests\Admin\Order\WithdrawRequest;

class OrderController extends Controller
{

    public function getOrder(ListRequest $request)
    {
        $data = $request->all();
        $order = Order::withTrashed()
        ->whereId($data['id_order'])
        ->with('store')
        ->with('share')
        ->with('delivery')
        ->with('payment')
        ->with('products')
        ->with('customer')
        ->first();
        return response()->json(['state' => 'success', 'response' => $order], 200);
    }

    public function getList(ListRequest $request)
    {
        $data = $request->all();

        $orders = Order::with('store')
        ->with('share')
        ->with('delivery')
        ->with('payment')
        ->with('products')
        ->with('customer');

        if(!$data['user']->hasRole(['root', 'master']))
        {
            $orders = $orders->where('id_store', '=', $data['user']->store_user->id_store);
        }

        $orders = $orders->orderBy('id_number', $data['sort'])
        ->paginate($data['paginate']);
        return response()->json(['state' => 'success', 'response' => $orders], 200);
    }

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id_store'];
            unset($data['id_store']);
            Order::whereId($id)->update($data);
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'update'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('OrderController@update: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_update'], 401);
        }
    }

    public function trash(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id_store'];
            Order::whereId($id)->delete();
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'trashed'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('OrderController@trash: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_trashed'], 401);
        }
    }

    public function restore(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id_store'];
            Order::withTrashed()->whereId($id)->restore();
            DB::commit();
            return response()->json(['state' => 'success'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('OrderController@restore: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_restore'], 401);
        }
    }

    public function withdraw(WithdrawRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id_order'];
            Order::whereId($id)->update([
                'withdraw' => 'success',
                'nota_fiscal' => $data['nota']
            ]);
            DB::commit();
            return response()->json(['state' => 'success'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('OrderController@restore: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_updated'], 401);
        }
    }

}
