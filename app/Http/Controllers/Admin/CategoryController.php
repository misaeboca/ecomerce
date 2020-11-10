<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Clients\Interfaces\IClientMethod;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\ListRequest;
use App\Http\Requests\Admin\Category\StatusRequest;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Models\GlobalStatus;

class CategoryController extends Controller
{
    private $clientMethod;

    public function __construct(IClientMethod $clientMethod)
    {
        $this->clientMethod = $clientMethod;
    }

    public function getList(ListRequest $request)
    {
        $data = $request->all();
        $categories = Category::whereIdClient($this->clientMethod->getIdClient())
        //->whereNull('id_category')
        ->with('subCategories');

        if(isset($data['status']) && $data['status'] != 'all')
        {
            $categories = $categories->whereStatus($data['status']);
        }

        $categories = $categories->paginate($data['paginate']);
        return response()->json(['state' => 'success', 'response' => $categories], 200);
    }

    public function getFullList(ListRequest $request)
    {
        $data = $request->all();
        $categories = Category::whereIdClient($this->clientMethod->getIdClient())
        //->whereNull('id_category')
        ->with('subCategories')
        ->whereStatus(GlobalStatus::STATUS_ACTIVE)
        ->get();
        return response()->json(['state' => 'success', 'response' => ['data' => $categories]], 200);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['id'] = generateUniqueId();
            $data['slug'] = generateSlug($data['name']);
            $data['id_client'] = $this->clientMethod->getIdClient();
            $data['status'] = GlobalStatus::STATUS_ACTIVE;
            Category::create($data);
            DB::commit();
            return response()->json(['state' => 'success'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('CategoryController@store: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id'];
            unset($data['id']);
            Category::whereIdClient($this->clientMethod->getIdClient())
            ->whereId($id)
            ->update($data);
            DB::commit();
            return response()->json(['state' => 'success'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('CategoryController@update: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }

    public function setStatus(StatusRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $category = Category::whereIdClient($this->clientMethod->getIdClient())
            ->whereId($data['id'])
            ->first();

            $category->update([
                'status' => $category['status'] == GlobalStatus::STATUS_ACTIVE ? GlobalStatus::STATUS_INACTIVE : GlobalStatus::STATUS_ACTIVE
            ]);

            DB::commit();
            return response()->json(['state' => 'success'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('StoreController@setStatus: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }
}
