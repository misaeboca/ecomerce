<?php

namespace App\Http\Controllers\Common;

use DB;

use App\Models\Common\Share;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Share\ListRequest;
use Illuminate\Support\Facades\Request;

class ShareController extends Controller
{

    public function __construct(Request $request)
    {
    }

      /**
     *
     */
    public function getShare(ListRequest $request, $slug)
    {

            $data = $request->all();

            $share = Share::whereId($slug)->first();
            return response()->json(['state' => 'success', 'response' => $share], 200);

    }



}
