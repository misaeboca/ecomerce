<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'cartsshares', 'as' => 'cartsshares.'], function () {

    Route::post('setCart', 'Common\CartShareController@setCart')->name('setCart');
    Route::get('ws', 'Common\CartShareController@getWs')->name('getWs');
    Route::get('{id}/detail', 'Common\CartShareController@getCart')->name('getCart');

});
