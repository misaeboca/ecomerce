<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'exports', 'as' => 'export.'], function () {

    Route::group([], function () {
        Route::post('/csv/orders', 'Admin\ExportsController@ordersCsv')->name('ordersCsv');
    });

    Route::post('/csv/customer', 'Admin\ExportsController@customersCsv')->name('customersCsv');

});
