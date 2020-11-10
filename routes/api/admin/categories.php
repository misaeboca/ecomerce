<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Admin\CategoryController@getList')->name('getList');
        Route::get('fullList', 'Admin\CategoryController@getFullList')->name('getFullList');
    });

    Route::group(['middleware' => ['parameters-admin.admin']], function () {
        Route::get('{id}/detail', 'Admin\CategoryController@getProducts')->name('getProducts');
        Route::put('{id}/status', 'Admin\CategoryController@setStatus')->name('status');
    });

    Route::post('', 'Admin\CategoryController@store')->name('store');
});
