<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::group(['middleware' => ['paginator.admin', 'parameters.admin', 'parameters-admin.admin']], function () {
        Route::get('list/{id_store?}', 'Common\ProductController@getList')->name('getList');
        Route::get('listFeatureds/{id_store?}', 'Common\ProductController@getListFeatureds')->name('getListFeatureds');
        Route::get('listCategories/{id_store}/{category}', 'Common\ProductController@getListByCategory')->name('getListByCategory')->where('category', '(.*)');
    });

    Route::group(['middleware' => ['parameters-products.admin']], function () {
        Route::get('{product}/detail', 'Common\ProductController@getProduct')->name('getProduct');
        Route::get('{id_store}/stock/{product}{cod?}{sku?}', 'Common\ProductController@getStock')->name('getStock');
    });
});
