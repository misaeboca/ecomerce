<?php

namespace App\Http\Controllers\Common;

use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Click\SetClickRequest;
use App\Models\Admin\StoreClick;
use App\Models\Admin\StoreUser;
use App\Models\Common\User;

class ClickController extends Controller
{

    public function setClick(SetClickRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            switch($data['type'])
            {
                case 'visit':
                    $sc = StoreClick::where('stores_clicks.id_store', '=', $data['id'])///all users of id_store
                    ->join('stores_users as su', 'su.id_user', '=', 'stores_clicks.id_seller')
                    ->get()
                    ->groupBy('id_seller')
                    ->map(function ($item, $key) {
                        return ['total' => collect($item)->count(), 'seller' => $item];
                    })
                    ->min();

                    if(!$sc)
                    {
                        $su = StoreUser::whereIdStore($data['id'])->get();
                        foreach($su as $s)
                        {
                            StoreClick::create([
                                'id_store' => $data['id'],
                                'id_seller' => $s->id_user,
                                'register_date' => date('Y-m-d')
                            ]);
                        }

                        $sc = StoreClick::where('stores_clicks.id_store', '=', $data['id'])///all users of id_store
                        ->join('stores_users as su', 'su.id_user', '=', 'stores_clicks.id_seller')
                        ->get()
                        ->groupBy('id_seller')
                        ->map(function ($item, $key) {
                            return ['total' => collect($item)->count(), 'seller' => $item];
                        })
                        ->min();
                    }

                    StoreClick::create([
                        'id_store' => $data['id'],
                        'id_seller' => $sc['seller'][0]['id_seller'],
                        'register_date' => date('Y-m-d')
                    ]);

                    $user = User::whereCode($sc['seller'][0]['id_seller'])->with('store_user')->first();
                    DB::commit();
                return response()->json(['state' => 'success', 'response' => $user->store_user->whatsapp], 200);
            }

        }catch (\Exception $e) {
            DB::rollback();
            logError('ClickController@setClick: ' . $e->getMessage());
        }

        return response()->json(['state' => 'success', 'response' => []], 200);
    }

}
