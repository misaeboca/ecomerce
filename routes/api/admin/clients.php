<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'clients', 'as' => 'clients.', 'middleware' => ['is.master.admin']], function () {
    Route::get('list', 'Admin\ClientController@getList')->name('getList');
});
