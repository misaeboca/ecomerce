<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Common\CategoryController@getList')->name('getList');
    });

    Route::group(['middleware' => ['parameters-admin.admin']], function () {
        Route::get('{id}/detail', 'Common\CategoryController@getProducts')->name('getProducts');
    });

});
