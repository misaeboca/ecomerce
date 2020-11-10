<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {

    require(__DIR__ . '/api/common/index.php');
    require(__DIR__ . '/api/admin/files.php');
    //Route::post('banners/image', 'Admin\BannerController@store')->name('store');
    Route::group(['middleware' => ['jwt.verifytoken', 'is.authenticate.admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

        Route::group(['middleware' => ['is.root.admin']], function () {
            Route::post('register', 'Admin\Auth\RegisterController@register')->name('register');
        });

        require(__DIR__ . '/api/admin/index.php');
     });
 });
