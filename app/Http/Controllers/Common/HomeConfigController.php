<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\HomeConfig\GetRequest;
use App\Models\Common\HomeConfig;

class HomeConfigController extends Controller
{
    public function getHome(GetRequest $request)
    {
        $data = $request->all();
        $hc = HomeConfig::first();
        return response()->json(['state' => 'success', 'response' => ['data' => $hc]], 200);
    }

}
