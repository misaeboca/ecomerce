<?php

namespace App\Exports;

use DB;
use App\Models\Admin\Order;
use App\Models\Admin\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Carbon;

class CustomerExport implements FromCollection, WithHeadings
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

        $customers = Order::withTrashed()
        ->join('customers', 'customers.id', 'orders.id_customer')
        ->join('stores', 'stores.id', '=', 'orders.id_store')
        ->join('clients', 'clients.id', '=', 'stores.id_client')
        ->where('orders.created_at', '>=', $this->start_date)
        ->where('orders.created_at', '<=', $this->end_date);

     	if($data['user']->hasRole(['root', 'master']))
        {
            if(isset($data['id_store']))
            {
                $customers = $customers->where('orders.id_store', '=', $data['id_store']);
            }
        } else
        {
            $customers = $customers->where('orders.id_store', '=', $data['user']->store_user->id_store);
        }

     	$customers = $customers->select('customers.*', 'stores.name as store', 'orders.id as order_id', 'orders.created_at as date_create');
        $customers = $customers->orderBy('orders.created_at','desc');
        $customers = $customers->orderBy('orders.id_store');
        $customers = $customers->get();

	    $map = $customers->map(function($items){
		   $data['id'] = $items->id;
		   $data['name'] = $items->name;
		   $data['lastname'] = $items->lastname;
		   $data['email'] = $items->email;
		   $data['cpf'] = $items->cpf;
		   $data['phone'] = $items->phone;
		   $data['store'] = $items->store;
		   $data['date'] = Carbon::parse($items->date_create)->format('Y-m-d');
           $data['order_id'] = $items->order_id;
		   return $data;
		});

        return  $map;
    }


    public function map($orders): array
    {
        return [
            $orders->id,
            $orders->name,
            $orders->lastname,
            $orders->email,
            $orders->cpf,
            $orders->phone,
            $orders->store,
            $orders->date,
            $orders->order_id
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'Name',
            'LastName',
            'Email',
            'Cpf',
            'Phone',
            'Store',
            'Date',
            'Order_id'
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
