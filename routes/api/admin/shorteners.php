<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'shortener', 'as' => 'shortener.'], function () {

    Route::group(['middleware' => ['parameters-admin.admin']], function () {
        Route::post('{id_store}/generate', 'Admin\ShortenerController@generate')->name('generate');
        Route::post('{id_store}/generate2', 'Admin\ShortenerController@generate2')->name('generate2');
    });

});
