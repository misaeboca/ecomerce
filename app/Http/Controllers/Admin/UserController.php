<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\RoleRequest;

class UserController extends Controller
{

    public function getRole(RoleRequest $request) {
        $data = $request->all();

        $store = null;

        if($data['user']->store_user) {
            $store = $data['user']->store_user->store;
        }

        return response()->json(['state' => 'success', 'data' => ['role' => $data['user']->roles[0]->name, 'store' => $store, 'profile' =>  $data['user']->profile, 'id_user' => $data['user']->code]], 200);
    }


}
