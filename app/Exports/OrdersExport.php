<?php

namespace App\Exports;

use DB;
use App\Models\Admin\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Carbon;

class OrdersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request;
    protected $start_date;
    protected $end_date;



	public function __construct($request)
	{
	    $this->request = $request;
	}

    public function collection()
    {
    	$start_date = '';
    	$end_date = '';
    	$data = $this->request;

    	$this->setDate($data);

        $orders = Order::withTrashed()
        ->leftJoin('users', 'users.code', 'orders.id_seller')
        ->where('orders.created_at', '>=', $this->start_date)
        ->where('orders.created_at', '<=', $this->end_date)
        ->with('store')
        ->with('delivery')
        ->with('payment')
        ->with('customer');


     	if($data['user']->hasRole(['root', 'master']))
        {
            if(!empty($data['id_store']) && $data['id_store'] != 'all')
            {
                $orders = $orders->where('orders.id_store', '=', $data['id_store']);
            }
        } else
        {
            $orders = $orders->where('orders.id_store', '=', $data['user']->store_user->id_store);
        }

	    if($data['user']->hasRole(['root', 'master']) && !empty($data['id_seller']))
        {
            $orders = $orders->where('orders.id_seller', '=', $data['id_seller']);
        }else{
        	//ojo preguntar xq es vacio
        	//busco el user
            //$orders = $orders->where('users.code', '=', $data['user']->id);
        }

        if(!empty($data['id_payment']))
        {
            $orders = $orders->where('orders.id_payment', '=', $data['id_payment']);
        }

        if(!empty($data['id_delivery']))
        {
            $orders = $orders->where('orders.id_delivery', '=', $data['id_delivery']);
        }


     	$orders = $orders->select('orders.*', 'users.username');
        $orders = $orders->orderBy('orders.created_at','desc');
        $orders = $orders->orderBy('orders.id_store');
        $orders = $orders->get();

	    $map = $orders->map(function($items){
		   $data['id'] = $items->id;
		   $data['store'] = $items->store->id;
		   $data['seller'] = $items->username;
		   $data['delivery'] = $items->delivery ? $items->delivery->name : '';
		   $data['payment'] = $items->payment->name;
		   $data['customer'] = $items->customer->name.' '.$items->customer->lastname;
		   $data['subtotal'] = $items->subtotal;
		   $data['total'] = $items->total;
		   $data['status'] = $items->status;
		   $data['observations'] = $items->observations;
		   $data['delivery_cost'] = $items->delivery_cost;
		   $data['delivery_notify'] = $items->delivery_notify;
		   $data['created_at'] = Carbon::parse($items->created_at)->format('Y-m-d');
		   return $data;
		});

        return  $map;
    }


    public function map($orders): array
    {
        return [
            $orders->id,
            $orders->store->id,
            $orders->seller,
            $orders->delivery,
            $orders->payment,
            $orders->customer,
            $orders->subtotal,
            $orders->total,
            $orders->status,
            $orders->observations,
            $orders->delivery_cost,
            $orders->delivery_notify,
            $orders->created_at
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'Store',
            'User',
            'Delivery',
            'Payment',
            'Customer',
            'Subtotal',
            'Total',
            'Status',
            'Observations',
            'Delivery Cost',
            'Delivery Notify',
            'Date Create'
        ];
    }

    public function setDate($data)
    {

    	if(!empty($data['start_date'])){

            $this->start_date = $data['start_date'];

        }else{
            $end_date = Carbon::now();
            $this->end_date = $end_date->format('Y-m-d');

            $start_date = $end_date->subDays(7);
            $this->start_date = $start_date->format('Y-m-d');
        }

        if(!empty($data['end_date'])){
            $this->end_date = $data['end_date'];
        }else{
        	$end_date = Carbon::now();
            $this->end_date = $end_date->format('Y-m-d');
        }

    }

}
