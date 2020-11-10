<?php

namespace App\Http\Controllers\Common;

use App\Models\Common\Store;
use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Store\GetStockRequest;
use App\Http\Requests\Common\Store\ListRequest;
use App\Models\Admin\StoreProduct;
use App\Models\GlobalStatus;

class StoreController extends Controller
{

    public function getStore(ListRequest $request)
    {
        $data = $request->all();
        $store = Store::whereId($data['id'])->whereStatus(GlobalStatus::STATUS_ACTIVE)->first();
        return response()->json(['state' => 'success', 'response' => $store], 200);
    }

    public function getList(ListRequest $request)
    {
        $stores = Store::whereStatus(GlobalStatus::STATUS_ACTIVE)->get();
        return response()->json(['state' => 'success', 'response' => $stores], 200);
    }

    public function geStock(GetStockRequest $request)
    {
        $data = $request->all();
        $store = StoreProduct::whereStatus(GlobalStatus::STATUS_ACTIVE)->whereIdStore($data['id'])->whereSku($data['sku'])->first();
        $stock = 0;
        if($store)
        {
            $stock = $store->stock;
        }
        return response()->json(['state' => 'success', 'response' => $stock], 200);
    }

}
