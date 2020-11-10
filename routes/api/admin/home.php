<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
    Route::post('', 'Admin\HomeConfigController@store')->name('store');
});
