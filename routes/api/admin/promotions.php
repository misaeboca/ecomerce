<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'promotions', 'as' => 'promotions.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin', 'parameters-admin.admin']], function () {
        Route::get('list', 'Admin\PromotionController@getList')->name('getList');
    });

    Route::group(['middleware' => ['parameters-admin.admin']], function () {
        Route::get('{id}/detail', 'Admin\PromotionController@getDetail')->name('getDetail');
        Route::put('{id}/addProducts', 'Admin\PromotionController@addProduct')->name('addProduct');
    });

    Route::post('', 'Admin\PromotionController@store')->name('store');
});
