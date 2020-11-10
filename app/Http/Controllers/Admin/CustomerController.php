<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\ListRequest;
use App\Models\Admin\Order;

class CustomerController extends Controller
{

    public function getCustomer(ListRequest $request)
    {
        $data = $request->all();
        $customer = Customer::withTrashed()
        ->where('customers.id', '=', $data['id_customer'])
        ->first();

        //las compras del cliente <<id_customer>>
        $orders = Order::where('id_customer', '=', $data['id_customer']);

        if(!$data['user']->hasRole(['root', 'master']))//las ventas del vendedor actual <<$user->code>> con el cliente <<id_customer>>
        {
            $orders = $orders->where('id_store', '=', $data['user']->store_user->id_store);
        }

        $orders = $orders->get();
        $customer->orders = $orders;
        return response()->json(['state' => 'success', 'response' => $customer], 200);
    }

    public function getList(ListRequest $request)
    {
        $data = $request->all();
        $customers = Customer::select('customers.*')->where('name', 'like', '%' . $data['search'] . '%' );

        if(!$data['user']->hasRole(['root', 'master']))
        {
            $customers = $customers->join('stores_customers as cs', 'cs.id_customer', '=', 'customers.id')
            ->where('cs.id_store', '=', $data['user']->store_user->id_store);
        }

       $customers = $customers->orderBy('customers.id_number', $data['sort'])
       ->with('store')
        ->paginate($data['paginate']);
        return response()->json(['state' => 'success', 'response' => $customers], 200);
    }

}
