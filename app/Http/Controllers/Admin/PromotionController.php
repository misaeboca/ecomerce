<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Promotions\AddProductRequest;
use App\Http\Requests\Admin\Promotions\GetRequest;
use App\Http\Requests\Admin\Promotions\ListRequest;
use App\Http\Requests\Admin\Promotions\StoreRequest;
use App\Http\Requests\Admin\Promotions\UpdateRequest;
use App\Models\Admin\Client;
use App\Models\Admin\Promotion;
use App\Models\Admin\PromotionProduct;
use App\Models\Common\Store;

class PromotionController extends Controller
{
    public function getPromotion(GetRequest $request)
    {
        $data = $request->all();
        $promotion = Promotion::whereId($data['id'])->first();
        return response()->json(['state' => 'success', 'response' => $promotion], 200);
    }

    public function getList(ListRequest $request)
    {
        $data = $request->all();
        $client = Client::first();
        $promotions = Promotion::whereIdClient($client->id)->get();
        return response()->json(['state' => 'success', 'response' => $promotions], 200);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();
            Promotion::create($data);
            DB::commit();
            return response()->json(['state' => 'success'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('BannerController@store: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_create'], 401);
        }
    }

    public function addProduct(AddProductRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();
            $client = Client::first();
            foreach($data['produtcs'] as $product)
            {
                if(PromotionProduct::whereIdClient($client->id)->whereIdPromotion($data['id'])->whereSku($product['sku'])->count() <= 0)
                {
                    PromotionProduct::create([
                        'id_promotion' => $data['id_promotion'],
                        'sku' => $product['sku'],
                        'id_client' => $client->id
                    ]);
                }
            }

            DB::commit();
            return response()->json(['state' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            logError('BannerController@update: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_update'], 401);
        }
    }

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();
            $usc = $data['id_store'];
            unset($data['id_store']);
            Store::whereId($usc)->update($data);
            DB::commit();
            return response()->json(['state' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            logError('BannerController@update: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_update'], 401);
        }
    }

}
