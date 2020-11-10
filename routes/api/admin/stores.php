<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'stores', 'as' => 'stores.'], function () {

    Route::get('mystore', 'Admin\StoreController@getMyStore')->name('getMyStore');
    Route::put('updateMyStore', 'Admin\StoreController@updateMyStore')->name('updateMyStore');

    Route::group(['middleware' => ['is.master.admin']], function () {

        Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
            Route::get('list', 'Admin\StoreController@getList')->name('getList');
            Route::get('listSelect', 'Admin\StoreController@getListSelect')->name('getListSelect');
        });

        Route::group(['middleware' => ['parameters-admin.admin']], function () {
            Route::get('{id}/detail', 'Admin\StoreController@getStore')->name('getStore');
            Route::get('{id}/users', 'Admin\StoreController@getStoreUsers')->name('getStoreUsers');
            Route::post('', 'Admin\StoreController@store')->name('store');
            Route::put('{id}', 'Admin\StoreController@update')->name('update');
            Route::put('{id}/trash', 'Admin\StoreController@trash')->name('trash');
            Route::put('{id}/restore', 'Admin\StoreController@restore')->name('restore');
            Route::put('{id}/addUser', 'Admin\StoreController@addUser')->name('addUser');
            Route::put('{id}/addFeatureds', 'Admin\StoreController@addFeatureds')->name('addFeatureds');
            Route::put('{id}/status', 'Admin\StoreController@setStatus')->name('status');
        });

        Route::post('', 'Admin\StoreController@store')->name('store');

    });
});
