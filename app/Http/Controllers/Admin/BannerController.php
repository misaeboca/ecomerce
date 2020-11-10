<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banner\GetRequest;
use App\Http\Requests\Admin\Banner\ListRequest;
use App\Http\Requests\Admin\Banner\StoreRequest;
use App\Http\Requests\Admin\Banner\UpdateRequest;
use App\Models\Admin\Banner;
use App\Models\Admin\BannerFile;
use App\Models\Common\Store;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function getBanner(GetRequest $request)
    {
        $data = $request->all();
        $store = Banner::whereId($data['id_banner'])->first();
        return response()->json(['state' => 'success', 'response' => $store], 200);
    }

    public function getList(ListRequest $request)
    {
        $data = $request->all();
        $banners = Banner::with('files');
        if(isset($data['id_store']))
        {
            $banners = $banners->whereId($data['id_store']);
        }

        $banners = $banners->get();
        return response()->json(['state' => 'success', 'response' => $banners], 200);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();
            $name = generateUniqueId();
            $extension = $data['file']->getClientOriginalExtension();
            $fileName = $name . '.' . $extension;
            Storage::disk('local')->putFileAs('public/images/', $data['file'], $fileName);
            /*$data['id_banner'] = generateUniqueId();

            $banner = Banner::create([
                'id_store' => $data['id_store'],
                'id_banner' => $data['id_banner'],
                'name' => isset($data['name']) ? $data['name'] : generateUniqueId()
            ]);

            foreach($data['files'] as $file)
            {
                $name = generateUniqueId();
                $extension = $file->getClientOriginalExtension();
                $fileName = $name . '.' . $extension;
                Storage::disk('local')->putFileAs('public/' . $data['id_store'] . '/', $file, $fileName);

                BannerFile::create([
                    'id_banner' => $banner['id_banner'],
                    'name' => $name,
                    'file_name' => $fileName,
                    //'url' => isset($file['url']) ? $file['url'] : null
                ]);

            }*/

            DB::commit();
            return response()->json(['state' => 'success', 'response' => env('APP_URL') . '/storage/images/' . $fileName ], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('BannerController@store: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_create'], 401);
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
            return response()->json(['state' => 'success', 'msg' => 'update'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            logError('BannerController@update: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_update'], 401);
        }
    }

    public function trash(UpdateRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();
            $id = $data['id_store'];
            Store::whereId($id)->delete();
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'trashed'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            logError('BannerController@trash: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_trashed'], 401);
        }
    }

    public function restore(UpdateRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();
            $id = $data['id_store'];
            Store::withTrashed()->whereId($id)->restore();
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'restore'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            logError('BannerController@restore: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_restore'], 401);
        }
    }

}
