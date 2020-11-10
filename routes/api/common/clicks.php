<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'stores', 'as' => 'stores.'], function () {

    Route::group(['middleware' => ['parameters-admin.admin']], function () {
        Route::post('{id}/click', 'Common\ClickController@setClick')->name('setClick');
    });

});
