<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Admin\Share;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Share\TrashRequest;
use App\Http\Requests\Admin\Share\RestoreRequest;
use App\Http\Requests\Admin\Share\ListRequest;
use App\Http\Requests\Admin\Share\StoreRequest;
use App\Http\Requests\Admin\Share\UpdateRequest;
use Illuminate\Support\Facades\Request;

class ShareController extends Controller
{

    public function __construct(Request $request)
    {
    }


    /**
     * @api {get} /shares/list List
     * @apiVersion 1.0.0
     * @apiGroup Shares
     * @apiName List
     * @apiDescription Get list Shares.
     *
     * @apiHeaderExample {json} Header-Example:
     *    {
     *      "Content-Type": "application/json",
     *      "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ19.eyJpc3MiOiJodHRwL3YxXC9hdXFuZXRhLmxvY2FsXC9hcGlcL3YxXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE1ODY2NDUyNjUsImV4cCI6MTU4NjY0ODg2NSwibmJmIjoxNTg2NjQ1MjY1LCJqdGkiOiJqUUIzdElTdWNvdFZYQ0hYIiwic3ViIjoxMDIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.PZCZrKxOGpDGkTa-ZZCA9wX3tkn8IjQFvdcDekR-NP0"
     *    }
     *
     *
     * @apiParam {Number} [page] Get list of page <code>page</code> by default 1.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "response": {
     *           "current_page": 1,
     *           "data": [{
     *             "json" : {}
     *           }],
     *           "first_page_url": "http://flowdevs.com/api/v1/shares/list?page=1",
     *           "from": null,
     *           "last_page": 1,
     *           "last_page_url": "http://flowdevs.com/api/v1/shares/list?page=1",
     *           "next_page_url": null,
     *           "path": "http://flowdevs.com/api/v1/shares/list",
     *            "per_page": 10,
     *            "prev_page_url": null,
     *            "to": null,
     *            "total": 0
     *        }
     *    }
     *
     */
    public function getList(ListRequest $request)
    {
        $data = $request->all();
        $shares = Share::where('id_user', $data['user']->code)->orderBy('id_number', $data['sort'])->paginate($data['paginate']);
        return response()->json(['state' => 'success', 'response' => $shares], 200);
    }

    /**
     * @api {post} /shares Add
     * @apiVersion 1.0.0
     * @apiGroup Shares
     * @apiName Add
     * @apiDescription Permite registrar un nuevo Share.
     *
     * @apiHeaderExample {json} Header-Example:
     *    {
     *      "Content-Type": "application/json",
     *      "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ19.eyJpc3MiOiJodHRwL3YxXC9hdXFuZXRhLmxvY2FsXC9hcGlcL3YxXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE1ODY2NDUyNjUsImV4cCI6MTU4NjY0ODg2NSwibmJmIjoxNTg2NjQ1MjY1LCJqdGkiOiJqUUIzdElTdWNvdFZYQ0hYIiwic3ViIjoxMDIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.PZCZrKxOGpDGkTa-ZZCA9wX3tkn8IjQFvdcDekR-NP0"
     *    }
     *
     * @apiParam {String} ushtc <code>Id</code> of <code>ShareType</code>.
     * @apiParam {String} json Informacion en formato json del <code>Share</code>. Max 5000 characters.
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "create"
     *   }
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_create El Share no pudo ser creado.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_create"
     *     }
     *
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $share = Share::create([
                'id' => generateUniqueId(),
                'id_share_type' => $data['id_share_type'],
                'id_store' => $data['user']->store_user->id_store,
                'id_user' =>  $data['user']->code,
                'json' => json_encode($data['json'])
            ]);
            DB::commit();
            return response()->json(['state' => 'success', 'response' => $share, 'msg' => 'create'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ShareController@store: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_create'], 401);
        }
    }

    /**
     * @api {put} /shares/{ushc}/update Update
     * @apiVersion 1.0.0
     * @apiGroup Shares
     * @apiName Update
     * @apiDescription Permite actualizar los datos de un Share.
     *
     * @apiHeaderExample {json} Header-Example:
     *    {
     *      "Content-Type": "application/json",
     *      "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ19.eyJpc3MiOiJodHRwL3YxXC9hdXFuZXRhLmxvY2FsXC9hcGlcL3YxXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE1ODY2NDUyNjUsImV4cCI6MTU4NjY0ODg2NSwibmJmIjoxNTg2NjQ1MjY1LCJqdGkiOiJqUUIzdElTdWNvdFZYQ0hYIiwic3ViIjoxMDIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.PZCZrKxOGpDGkTa-ZZCA9wX3tkn8IjQFvdcDekR-NP0"
     *    }
     *
     * @apiParam {String} ushc <code>Id</code> del <code>Share</code>.
     * @apiParam {String} ushtc <code>Id</code> of <code>ShareType</code>.
     * @apiParam {String} json Informacion en formato json del <code>Share</code>. Max 5000 characters.
     *
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "update"
     *   }
     *
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_update El Share no se pudo actualizar, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_update"
     *     }
     *
     */
    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id'];
            Share::whereId($id)->update([
                'json' => $data['json']
            ]);
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'update'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ShareController@update: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_update'], 401);
        }
    }

    /**
     * @api {put} /shares/{ushc}/trash Trash
     * @apiVersion 1.0.0
     * @apiGroup Shares
     * @apiName Trash
     * @apiDescription Permite enviar un produto a la papelera.
     *
     * @apiHeaderExample {json} Header-Example:
     *    {
     *      "Content-Type": "application/json",
     *      "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ19.eyJpc3MiOiJodHRwL3YxXC9hdXFuZXRhLmxvY2FsXC9hcGlcL3YxXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE1ODY2NDUyNjUsImV4cCI6MTU4NjY0ODg2NSwibmJmIjoxNTg2NjQ1MjY1LCJqdGkiOiJqUUIzdElTdWNvdFZYQ0hYIiwic3ViIjoxMDIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.PZCZrKxOGpDGkTa-ZZCA9wX3tkn8IjQFvdcDekR-NP0"
     *    }
     *
     * @apiParam {String} [ushc] <code>Id</code> del <code>Share</code>.
     *
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "trashed"
     *   }
     *
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_update El Share no se pudo actualizar, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_trashed"
     *     }
     *
     */
    public function trash(TrashRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id'];
            Share::whereId($id)->delete();
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'trashed'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ShareController@trash: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_trashed'], 401);
        }
    }

    /**
     * @api {put} /shares/{ushc}/restore Restore
     * @apiVersion 1.0.0
     * @apiGroup Shares
     * @apiName Restore
     * @apiDescription Permite restaurar un share enviado a la papelera.
     *
     * @apiHeaderExample {json} Header-Example:
     *    {
     *      "Content-Type": "application/json",
     *      "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ19.eyJpc3MiOiJodHRwL3YxXC9hdXFuZXRhLmxvY2FsXC9hcGlcL3YxXC9hdXRoZW50aWNhdGUiLCJpYXQiOjE1ODY2NDUyNjUsImV4cCI6MTU4NjY0ODg2NSwibmJmIjoxNTg2NjQ1MjY1LCJqdGkiOiJqUUIzdElTdWNvdFZYQ0hYIiwic3ViIjoxMDIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.PZCZrKxOGpDGkTa-ZZCA9wX3tkn8IjQFvdcDekR-NP0"
     *    }
     *
     * @apiParam {String} [ushc] <code>Id</code> del <code>Share</code>.
     *
     *
     * @apiSuccessExample Success-Response:
     *   HTTP/1.1 200 OK
     *   {
     *       "state": "success",
     *       "msg": "restore"
     *   }
     *
     *
     * @apiError require El campo es obligatorio.
     * @apiError no_restore El Share no se pudo actualizar, contacte con el administrador.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 401 Not Found
     *     {
     *       "state": "fail",
     *       "errors": "no_restore"
     *     }
     *
     */
    public function restore(RestoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id'];
            Share::withTrashed()->whereId($id)->restore();
            DB::commit();
            return response()->json(['state' => 'success', 'msg' => 'restore'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ShareController@restore: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'msg' => 'no_restore'], 401);
        }
    }

}
