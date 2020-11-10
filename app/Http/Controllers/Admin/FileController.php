<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\File\StoreRequest;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function store(StoreRequest $request)
    {
        try
        {
            $data = $request->all();
            $name = generateUniqueId();
            $extension = $data['file']->getClientOriginalExtension();
            $fileName = $name . '.' . $extension;
            Storage::disk('local')->putFileAs('public/images/', $data['file'], $fileName);
            return response()->json(['state' => 'success', "response" => [ "data" =>env('APP_URL') . 'storage/public/images/' . $fileName]], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('BannerController@store: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_create'], 401);
        }
    }
}
