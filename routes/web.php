<?php

use App\Models\Admin\Order;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'mails', 'as' => 'web.'], function () {
    Route::get('/newOrderMail', function () {
        return view('mails.newOrder')->with(['data' => Order::first()]);
    });
});
