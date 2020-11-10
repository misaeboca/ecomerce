<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'customers', 'as' => 'customers.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Admin\CustomerController@getList')->name('getList');
    });

    Route::group(['middleware' => ['parameters-customers.admin']], function () {
        Route::get('{id_customer}/detail', 'Admin\CustomerController@getCustomer')->name('getCustomer');
    });
});
