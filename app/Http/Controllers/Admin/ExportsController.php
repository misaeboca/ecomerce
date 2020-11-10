<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Exports\OrderRequest;
use App\Http\Requests\Admin\Exports\CustomerRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;
use App\Exports\OrdersExport;
use App\Exports\CustomerExport;

class ExportsController extends Controller
{

    public function ordersCsv(OrderRequest $request)
    {
        $data = $request->all();

        $end_date = Carbon::now();
        $end_date = $end_date->format('Y-m-d');

        $name = generateUniqueId().'.csv';

        if(Excel::store(new OrdersExport($data), 'exports/' . $name, 'local')){

            return response()->json(['state' => 'success', 'response' =>  env('APP_URL') .'storage/exports/'.$name], 200);
        } else {

            return response()->json(['state' => 'fails', 'response' => 'error in donwload file'], 400);
        }
    }

    public function customersCsv(CustomerRequest $request)
        {
        $data = $request->all();

        $end_date = Carbon::now();
        $end_date = $end_date->format('Y-m-d');

        $name = generateUniqueId().'.csv';

        if(Excel::store(new CustomerExport($data), 'exports/'.$name, 'local')){

            return response()->json(['state' => 'success', 'response' =>  env('APP_URL') .'storage/exports/'.$name], 200);
        } else {

            return response()->json(['state' => 'fails', 'response' => 'error in donwload fiel'], 400);
        }
    }


}
