<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Admin\OrderController@getList')->name('getList');
    });

    Route::group(['middleware' => ['parameters-orders.admin']], function () {
        Route::get('{id_order}/detail', 'Admin\OrderController@getOrder')->name('getOrder');
        Route::put('{id_order}', 'Admin\OrderController@update')->name('update');
        Route::put('{id_order}/trash', 'Admin\OrderController@trash')->name('trash');
        Route::put('{id_order}/restore', 'Admin\OrderController@restore')->name('restore');
        Route::put('{id_order}/notify', 'Admin\DeliveryController@notify')->name('notify');
        Route::put('{id_order}/withdraw', 'Admin\OrderController@withdraw')->name('withdraw');
        Route::post('/export/csv/orders', 'Admin\ExportsController@ordersCsv')->name('exportCsv');
    });

});
