<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {

    Route::post('getRole', 'Admin\UserController@getRole')->name('getRole');

});
