<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'shares', 'as' => 'shares.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Admin\ShareController@getList')->name('getList');
    });


    Route::post('', 'Admin\ShareController@store')->name('store');
    Route::put('{id}', 'Admin\ShareController@update')->name('update');
    Route::post('{id}/trash', 'Admin\ShareController@trash')->name('trash');
    Route::put('{id}/restore', 'Admin\ShareController@restore')->name('restore');
});
