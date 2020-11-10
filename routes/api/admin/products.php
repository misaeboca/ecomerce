<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::group(['middleware' => ['paginator.admin', 'parameters.admin', 'parameters-admin.admin']], function () {
        Route::get('list', 'Admin\ProductController@getList')->name('getList');
        Route::get('fullist', 'Admin\ProductController@geFulltList')->name('geFulltList');
        Route::get('listFeatureds/{id_store?}', 'Admin\ProductController@getListFeatureds')->name('getListFeatureds');
    });

    Route::group(['middleware' => ['parameters-products.admin']], function () {
        Route::get('{product}/detail', 'Admin\ProductController@getProduct')->name('getProduct');
        Route::put('{product}', 'Admin\ProductController@update')->name('update');
        Route::put('{product}/trash', 'Admin\ProductController@trash')->name('trash');
        Route::put('{product}/restore', 'Admin\ProductController@restore')->name('restore');
        Route::put('{product}/status', 'Admin\ProductController@setStatus')->name('status');
    });

    Route::group(['middleware' => ['parameters-products-image.admin']], function () {
        Route::put('{product}/images', 'Admin\ProductController@addImage')->name('addImage');
        Route::put('{product}/images/{id_image}', 'Admin\ProductController@deleteImage')->name('deleteImage');
        Route::put('{product}/category', 'Admin\ProductController@addCategory')->name('addCategory');
        Route::put('{product}/category/{id_category}', 'Admin\ProductController@deleteCategory')->name('deleteCategory');
    });

    Route::post('', 'Admin\ProductController@store')->name('store');

});
