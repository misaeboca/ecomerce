<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'sharetypes', 'as' => 'sharetypes.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Admin\ShareTypeController@getList')->name('getList');
    });

    Route::group(['middleware' => ['parameters-sharestypes.admin']], function () {
        Route::get('{ushtc}/detail', 'Admin\ShareTypeController@getProduct')->name('getProduct');
        Route::put('{ushtc}', 'Admin\ShareTypeController@update')->name('update');
        Route::put('{ushtc}/trash', 'Admin\ShareTypeController@trash')->name('trash');
        Route::put('{ushtc}/restore', 'Admin\ShareTypeController@restore')->name('restore');
    });

    Route::post('', 'Admin\ShareTypeController@store')->name('store');

});
