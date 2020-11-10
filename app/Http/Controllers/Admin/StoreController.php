<?php

namespace App\Http\Controllers\Admin;

use App\Clients\Interfaces\IClientMethod;
use DB;
use App\Models\Admin\Store;
use App\Models\Admin\ProductFeatured;
use App\Models\Admin\Rol;
use App\Models\Admin\RolUser;
use App\Models\Admin\StoreLoggi;
use App\Models\Admin\StoreUser;
use App\Models\Admin\User;
use App\Models\Admin\UserProfile;
use App\Models\Admin\StoreBraspag;
use App\Models\Admin\StoreCielo;
use App\Models\Admin\StoreSchedule;
use App\Deliveries\Loggi\Loggi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\AddFeaturedRequest;
use App\Http\Requests\Admin\Store\AddUserRequest;
use App\Http\Requests\Admin\Store\ListRequest;
use App\Http\Requests\Admin\Store\StatusRequest;
use App\Http\Requests\Admin\Store\StoreRequest;
use App\Http\Requests\Admin\Store\UpdateMyStoreRequest;
use App\Http\Requests\Admin\Store\UpdateRequest;
use App\Models\GlobalStatus;

class StoreController extends Controller
{
    private $clientMethod;

    public function __construct(IClientMethod $clientMethod)
    {
        $this->clientMethod = $clientMethod;
    }

    public function getStore(ListRequest $request)
    {
        $data = $request->all();
        $store = Store::whereIdClient($this->clientMethod->getIdClient())
        ->whereId($data['id'])
        ->with('loggi')
        ->with('schedules')
        ->with('braspag')
        ->first();
        return response()->json(['state' => 'success', 'response' => $store], 200);
    }

    public function getMyStore(ListRequest $request)
    {
        $data = $request->all();
        $store = Store::whereIdClient($this->clientMethod->getIdClient())
        ->whereId($data['user']->store_user->id_store)
        ->with('loggi')
        ->with('schedules')
        ->with('braspag')
        ->first();
        return response()->json(['state' => 'success', 'response' => $store], 200);
    }

    public function getStoreUsers(ListRequest $request)
    {
        $data = $request->all();

        $stores = StoreUser::select('id_user')
        ->whereIdStore($data['id'])
        ->get()
        ->toArray();

        $users = User::whereIn('code', $stores)->get();

        return response()->json(['state' => 'success', 'response' => $stores ? $users : []], 200);
    }

    public function getList(ListRequest $request)
    {
        $data = $request->all();
        $stores = Store::whereIdClient($this->clientMethod->getIdClient())
        ->where('name', 'like', '%' . $data['search'] . '%' )
        ->with('schedules')
        ->paginate($data['paginate']);
        return response()->json(['state' => 'success', 'response' => $stores], 200);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $slug = generateSlug($data['name']);
            $data['id'] = $slug;
            $data['domain'] = env('APP_BASE_STORE_URL') . $slug;
            $data['pickup'] = isset($data['pickup']) ? true : false;
            $data['id_client'] = $this->clientMethod->getIdClient();
            $store = Store::create($data);

            if(isset($data['schedules']))
            {
                StoreSchedule::create([
                    'id_store' => $store->id,
                    'monday_opening' => isset($data['schedules']['monday_opening']) ? $data['schedules']['monday_opening'] : null,
                    'monday_closing' => isset($data['schedules']['monday_closing']) ? $data['schedules']['monday_closing'] : null,
                    'tuesday_opening'=>  isset($data['schedules']['tuesday_opening']) ? $data['schedules']['tuesday_opening'] : null,
                    'tuesday_closing' => isset($data['schedules']['tuesday_closing']) ? $data['schedules']['tuesday_closing'] : null,
                    'wednesday_opening'=>  isset($data['schedules']['wednesday_opening']) ? $data['schedules']['wednesday_opening'] : null,
                    'wednesday_closing' => isset($data['schedules']['wednesday_closing']) ? $data['schedules']['wednesday_closing'] : null,
                    'thursday_opening'=>  isset($data['schedules']['thursday_opening']) ? $data['schedules']['thursday_opening'] : null,
                    'thursday_closing' => isset($data['schedules']['thursday_closing']) ? $data['schedules']['thursday_closing'] : null,
                    'friday_opening'=>  isset($data['schedules']['friday_opening']) ? $data['schedules']['friday_opening'] : null,
                    'friday_closing' => isset($data['schedules']['friday_closing']) ? $data['schedules']['friday_closing'] : null,
                    'saturday_opening'=>  isset($data['schedules']['saturday_opening']) ? $data['schedules']['saturday_opening'] : null,
                    'saturday_closing' => isset($data['schedules']['saturday_closing']) ? $data['schedules']['saturday_closing'] : null,
                    'sunday_opening' =>  isset($data['schedules']['sunday_opening']) ? $data['schedules']['sunday_opening'] : null,
                    'sunday_closing' => isset($data['schedules']['sunday_closing']) ? $data['schedules']['sunday_closing'] : null
                ]);
            }

            if(isset($data['braspag']))
            {
                StoreBraspag::create([
                    'id_store' => $store->id,
                    'merchant_id' => $data['braspag']['merchant_id'],
                    'merchant_key' => $data['braspag']['merchant_key']
                ]);
            }

            if(isset($data['cielo']))
            {
                StoreCielo::create([
                    'id_store' => $store->id,
                    'merchant_id' => $data['cielo']['merchant_id'],
                    'merchant_key' => $data['cielo']['merchant_key']
                ]);
            }

            if(isset($data['loggi']))
            {
                $loggi = new Loggi($data['loggi']['user']);
                $res = $loggi->config(['apikey' => $data['loggi']['api_key']]);

                if($res->pk == -1) {
                    logError('StoreController@store: fail with loggi: ' . $data['loggi']['user']);
                    return response()->json(['state' => 'fail', 'msg' => 'fail.loggi_connect'], 401);
                }

                $data['loggi']['shopId'] = isset($res->pk) ? $res->pk : null;
                $data['loggi']['api_key'] = isset($res->api_key) ? $res->api_key : null;

                $store->update(['coordinates' => json_encode($res->coordinates)]);

                StoreLoggi::create([
                    'id_store' => $store->id,
                    'user' => $data['loggi']['user'],
                    //'password' => $data['loggi']['password'],
                    'distance' => $data['loggi']['distance'],
                    'shop' => $data['loggi']['shopId'],
                    'api_key' => $data['loggi']['api_key']
                ]);
            }

            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'create'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('StoreController@store: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_create'], 401);
        }
    }

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id'];
            unset($data['id']);
            Store::whereIdClient($this->clientMethod->getIdClient())->whereId($id)->update($data);
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'update'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('StoreController@update: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_update'], 401);
        }
    }

    public function updateMyStore(UpdateMyStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            Store::whereIdClient($this->clientMethod->getIdClient())
            ->whereId($data['user']->store_user->id_store)
            ->update([
                'pickup' => isset($data['pickup']) ? true : false,
            ]);
            if(StoreSchedule::whereIdStore($data['user']->store_user->id_store)->count() > 0)
            {
                StoreSchedule::whereIdStore($data['user']->store_user->id_store)->update([
                    'monday_opening' => isset($data['schedules']['monday_opening']) ? $data['schedules']['monday_opening'] : null,
                    'monday_closing' => isset($data['schedules']['monday_closing']) ? $data['schedules']['monday_closing'] : null,
                    'tuesday_opening'=>  isset($data['schedules']['tuesday_opening']) ? $data['schedules']['tuesday_opening'] : null,
                    'tuesday_closing' => isset($data['schedules']['tuesday_closing']) ? $data['schedules']['tuesday_closing'] : null,
                    'wednesday_opening'=>  isset($data['schedules']['wednesday_opening']) ? $data['schedules']['wednesday_opening'] : null,
                    'wednesday_closing' => isset($data['schedules']['wednesday_closing']) ? $data['schedules']['wednesday_closing'] : null,
                    'thursday_opening'=>  isset($data['schedules']['thursday_opening']) ? $data['schedules']['thursday_opening'] : null,
                    'thursday_closing' => isset($data['schedules']['thursday_closing']) ? $data['schedules']['thursday_closing'] : null,
                    'friday_opening'=>  isset($data['schedules']['friday_opening']) ? $data['schedules']['friday_opening'] : null,
                    'friday_closing' => isset($data['schedules']['friday_closing']) ? $data['schedules']['friday_closing'] : null,
                    'saturday_opening'=>  isset($data['schedules']['saturday_opening']) ? $data['schedules']['saturday_opening'] : null,
                    'saturday_closing' => isset($data['schedules']['saturday_closing']) ? $data['schedules']['saturday_closing'] : null,
                    'sunday_opening' =>  isset($data['schedules']['sunday_opening']) ? $data['schedules']['sunday_opening'] : null,
                    'sunday_closing' => isset($data['schedules']['sunday_closing']) ? $data['schedules']['sunday_closing'] : null
                ]);
            } else
            {
                StoreSchedule::create([
                    'id_store' => $data['user']->store_user->id_store,
                    'monday_opening' => isset($data['schedules']['monday_opening']) ? $data['schedules']['monday_opening'] : null,
                    'monday_closing' => isset($data['schedules']['monday_closing']) ? $data['schedules']['monday_closing'] : null,
                    'tuesday_opening'=>  isset($data['schedules']['tuesday_opening']) ? $data['schedules']['tuesday_opening'] : null,
                    'tuesday_closing' => isset($data['schedules']['tuesday_closing']) ? $data['schedules']['tuesday_closing'] : null,
                    'wednesday_opening'=>  isset($data['schedules']['wednesday_opening']) ? $data['schedules']['wednesday_opening'] : null,
                    'wednesday_closing' => isset($data['schedules']['wednesday_closing']) ? $data['schedules']['wednesday_closing'] : null,
                    'thursday_opening'=>  isset($data['schedules']['thursday_opening']) ? $data['schedules']['thursday_opening'] : null,
                    'thursday_closing' => isset($data['schedules']['thursday_closing']) ? $data['schedules']['thursday_closing'] : null,
                    'friday_opening'=>  isset($data['schedules']['friday_opening']) ? $data['schedules']['friday_opening'] : null,
                    'friday_closing' => isset($data['schedules']['friday_closing']) ? $data['schedules']['friday_closing'] : null,
                    'saturday_opening'=>  isset($data['schedules']['saturday_opening']) ? $data['schedules']['saturday_opening'] : null,
                    'saturday_closing' => isset($data['schedules']['saturday_closing']) ? $data['schedules']['saturday_closing'] : null,
                    'sunday_opening' =>  isset($data['schedules']['sunday_opening']) ? $data['schedules']['sunday_opening'] : null,
                    'sunday_closing' => isset($data['schedules']['sunday_closing']) ? $data['schedules']['sunday_closing'] : null
                ]);
            }

            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'update'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('StoreController@update: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_update'], 401);
        }
    }

    public function trash(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id'];
            Store::whereIdClient($this->clientMethod->getIdClient())
            ->whereId($id)
            ->delete();
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'trashed'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('StoreController@trash: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_trashed'], 401);
        }
    }

    public function restore(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id'];
            Store::whereIdClient($this->clientMethod->getIdClient())
            ->withTrashed()
            ->whereId($id)
            ->restore();
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'restore'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('StoreController@restore: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_restore'], 401);
        }
    }

    public function addUser(AddUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();

            $dataSave = [
                'username'  => $data['username'],
                'email'  => $data['email'],
                'password' => hash(env('ENCRYPTION_ALGORITHM'), $data['password']),
                'code' => generateUniqueId(),
            ];

            $user = User::create($dataSave);
            $rol = Rol::whereName('store')->first();
            RolUser::create(['user_id' => $user->id, 'rol_id' => $rol['id']]);
            UserProfile::create(['id_user' => $user->code]);
            StoreUser::create([
                'id_user' => $user->code, 'id_store' => $data['id'], 'whatsapp' => $data['whatsapp']
            ]);
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'added'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('StoreController@restore: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_added'], 401);
        }
    }

    public function addFeatureds(AddFeaturedRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            foreach($data['products'] as $product)
            {
                if(ProductFeatured::whereGroup($data['group'])->whereId($data['id'])->count() <= 0) {
                    ProductFeatured::create([
                        'sku' => $product['sku'],
                        'id_store' => $data['id'],
                        'group' => $data['group']
                    ]);
                }
            }
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'added'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ProductController@addImage: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_added'], 401);
        }
    }

    public function getListSelect(ListRequest $request)
    {
        $stores = Store::whereIdClient($this->clientMethod->getIdClient())
        ->whereDisplay(1)
        ->get();
        return response()->json(['state' => 'success', 'response' => $stores], 200);
    }

    public function setStatus(StatusRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $store = Store::whereIdClient($this->clientMethod->getIdClient())
            ->whereId($data['id'])
            ->first();

            $store->update([
                'status' => $store['status'] == GlobalStatus::STATUS_ACTIVE ? GlobalStatus::STATUS_INACTIVE : GlobalStatus::STATUS_ACTIVE 
            ]);

            DB::commit();
            return response()->json(['state' => 'success'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('StoreController@setStatus: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_update'], 401);
        }
    }

}
