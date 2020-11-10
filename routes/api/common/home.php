<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
    Route::get('getHome', 'Common\HomeConfigController@getHome')->name('getHome');
    Route::get('verify', 'Common\CommonController@verify')->name('verify');


    Route::group(['middleware' => ['parameters-admin.admin']], function () {
        Route::get('getSeller/{id_store}/{code?}', 'Common\CommonController@getSeller')->name('getSeller');
    });
});
