<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {

    Route::group(['middleware' => ['parameters-orders-udc-public.admin']], function () {
        Route::post('cost', 'Common\OrderController@getCost')->name('getCost');
    });

    Route::group(['middleware' => ['parameters-orders-udc.admin']], function () {
        Route::post('', 'Common\OrderController@store')->name('store');
    });

    Route::group(['middleware' => ['parameters-public.admin']], function () {
        Route::post('{id_store}/addCustomer', 'Common\OrderController@addCustomer')->name('addCustomer');
    });

    Route::group(['middleware' => ['parameters-orders.admin']], function () {
        Route::put('{id_order}', 'Common\OrderController@refund')->name('refund');
    });

});
