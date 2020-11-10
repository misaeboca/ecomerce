<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'statistics', 'as' => 'statistics.', 'middleware' => ['paginator.admin', 'parameters.admin']], function () {
    Route::get('clicks/visit', 'Admin\StatisticsController@getClickList')->name('getClickList');
    Route::get('orders/total', 'Admin\StatisticsController@getOrdersList')->name('getOrdersList');
    Route::get('products/total', 'Admin\StatisticsController@getProductsList')->name('getProductsList');
});
