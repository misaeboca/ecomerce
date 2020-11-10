<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Store;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Store\ListRequest;
use App\Models\Admin\Client;

class ClientController extends Controller
{

    public function getList(ListRequest $request)
    {
        $clients = Client::all();
        return response()->json(['state' => 'success', 'response' => ['data' => $clients]], 200);
    }


}
