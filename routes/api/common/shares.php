<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'shares', 'as' => 'shares.'], function () {

    Route::get('{slug}/detail', 'Common\ShareController@getShare')->name('getShare');

});
