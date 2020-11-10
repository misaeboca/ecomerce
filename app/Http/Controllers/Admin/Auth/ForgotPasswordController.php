<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
