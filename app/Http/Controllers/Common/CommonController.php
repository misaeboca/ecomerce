<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\VerifyRequest;
use App\Http\Requests\Common\WhatsappRequest;
use App\Models\Admin\StoreClick;
use App\Models\Admin\StoreUser;
use App\Models\Admin\User;
use Illuminate\Support\Facades\Http;
use DB;

class CommonController extends Controller
{
    public function verify(VerifyRequest $request)
    {
        try {
            $data = $request->all();

            if(isset($data['cep']))
            {
                $response = Http::get('https://viacep.com.br/ws/' . $data['cep'] .'/json');
            }

            return response()->json(['state' => 'success', 'response' => $response->json()], 200);
        } catch (\Exception $e)
        {
            logError('CommonController@mail: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => []], 401);
        }
    }

    public function getSeller(WhatsappRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        if(isset($data['code']) && $data['code'] != 'undefined')
        {
            $user = User::wehreCode($data['code'])->with('store_user')->first();

        } else {
            $sc = StoreClick::where('stores_clicks.id_store', '=', $data['id_store'])///all users of id_store
            ->join('stores_users as su', 'su.id_user', '=', 'stores_clicks.id_seller')
            ->get()
            ->groupBy('id_seller')
            ->map(function ($item, $key) {
                return ['total' => collect($item)->count(), 'seller' => $item];
            })
            ->min();

            if(!$sc)
            {
                $su = StoreUser::whereIdStore($data['id_store'])->get();
                foreach($su as $s)
                {
                    StoreClick::create([
                        'id_store' => $data['id_store'],
                        'id_seller' => $s->id_user,
                        'register_date' => date('Y-m-d')
                    ]);
                }

                $sc = StoreClick::where('stores_clicks.id_store', '=', $data['id_store'])///all users of id_store
                ->join('stores_users as su', 'su.id_user', '=', 'stores_clicks.id_seller')
                ->get()
                ->groupBy('id_seller')
                ->map(function ($item, $key) {
                    return ['total' => collect($item)->count(), 'seller' => $item];
                })
                ->min();
            }

            $user = User::whereCode($sc['seller'][0]['id_seller'])->with('store_user')->first();
            DB::commit();

        }

        return response()->json(['state' => 'success', 'response' => $user->store_user->whatsapp], 200);

    }
}
