<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'themes', 'as' => 'themes.'], function () {

    Route::group(['middleware' => ['paginator.admin', 'parameters.admin']], function () {
        Route::get('list', 'Common\ThemeController@getList')->name('getList');
    });

    Route::group(['middleware' => ['parameters-admin.admin']], function () {
        Route::get('{id}/detail', 'Common\ThemeController@getProducts')->name('getProducts');
    });

});
