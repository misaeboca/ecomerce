<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin', 'parameters-admin.admin']], function () {
        Route::get('list/{usc?}', 'Admin\BannerController@getList')->name('getList');
    });

    Route::group(['middleware' => ['parameters-customers.admin']], function () {
        Route::get('{ubc}/detail', 'Admin\BannerController@getBanner')->name('getBanner');
    });

    Route::post('', 'Admin\BannerController@store')->name('store');
});
