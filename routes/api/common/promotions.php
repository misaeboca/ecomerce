<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'promotions', 'as' => 'promotions.'], function () {
    Route::group(['middleware' => ['parameters-products.admin']], function () {
        Route::get('{id_store}', 'Common\PromotionController@getPromotion')->name('getPromotion');
        Route::get('bad', 'Common\PromotionController@getPromotionNull')->name('getPromotionNull');
    });
});
