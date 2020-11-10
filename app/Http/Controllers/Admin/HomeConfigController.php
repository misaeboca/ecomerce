<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HomeConfig\StoreRequest;
use App\Models\Admin\HomeConfig;

class HomeConfigController extends Controller
{
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();

            if(HomeConfig::count() <= 0)
            {
                $hc = HomeConfig::create([
                    'home' => $data['home'],
                ]);
            } else
            {
                $hc = HomeConfig::first();
                $hc->update([
                    'home' => $data['home'],
                ]);
            }

            DB::commit();
            return response()->json(['state' => 'success', 'response' => $hc], 200);

        } catch (\Exception $e)
        {
            DB::rollback();
            logError('HomeConfigController@store: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_create'], 401);
        }
    }

}
