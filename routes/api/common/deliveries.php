<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'deliveries', 'as' => 'deliveries.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Common\DeliveryController@getList')->name('getList');
    });

    Route::get('ups', 'Common\UpsDelivery@enviar')->name('enviar');
});
