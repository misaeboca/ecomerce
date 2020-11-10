<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'materials', 'as' => 'materials.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Common\MaterialController@getList')->name('getList');
    });

    Route::group(['middleware' => ['parameters-admin.admin']], function () {
        Route::get('{id}/detail', 'Common\MaterialController@getProducts')->name('getProducts');
    });

});
