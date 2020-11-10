<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'payments', 'as' => 'payments.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Admin\PaymentController@getList')->name('getList');
    });
});
