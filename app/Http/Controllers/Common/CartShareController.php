<?php

namespace App\Http\Controllers\Common;

use DB;

use App\Models\Common\CartShare;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CartShare\SetCartRequest;
use App\Http\Requests\Admin\CartShare\WhatsappRequest;
use App\Http\Requests\Admin\Share\ListRequest;
use App\Models\Admin\StoreUser;
use Illuminate\Support\Facades\Request;

class CartShareController extends Controller
{

    public function __construct(Request $request)
    {
    }

    public function getCart(ListRequest $request,$id)
    {
        $data = $request->all();
        $cartShare = CartShare::where('id',$id)->first();
        return response()->json(['state' => 'success', 'response' => $cartShare], 200);
    }

    public function getWs(WhatsappRequest $request)
    {
        $data = $request->all();
        $su = StoreUser::whereIdStore($data['id_store'])->inRandomOrder()->first();

        return response()->json(['state' => 'success', 'response' => $su->whatsapp], 200);
    }

    public function setCart(SetCartRequest $request)
    {
        try {
            $data = $request->all();
            $cartShare = CartShare::create([
                'id' => generateUniqueId(),
                'id_store' => $data['id_store'],
                'json' => json_encode($data['json'])
            ]);
            return response()->json(['state' => 'success', 'response' => ['data' => $cartShare->id]], 200);
        }
        catch (\Exception $e)
        {
            logError('CartShareController@setCart: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 300]], 200);
        }


    }

}
