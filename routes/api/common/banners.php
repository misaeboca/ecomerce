<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
    Route::post('image', 'Admin\BannerController@store')->name('store');

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin', 'parameters-admin.admin']], function () {
        Route::get('list/{id_store?}', 'Common\BannerController@getList')->name('getList');
    });

    Route::group(['middleware' => ['parameters-customers.admin']], function () {
        Route::get('{id}/detail', 'Common\BannerController@getBanner')->name('getBanner');
    });

    //Route::post('image', 'Api\BannerController@store')->name('store');
});
