<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'stores', 'as' => 'stores.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Common\StoreController@getList')->name('getList');
    });

    Route::group(['middleware' => ['parameters-admin.admin']], function () {
        Route::get('{id}/detail', 'Common\StoreController@getStore')->name('getStore');
        Route::get('{id}/{sku}/stock', 'Common\StoreController@geStock')->name('geStock');
    });

});
