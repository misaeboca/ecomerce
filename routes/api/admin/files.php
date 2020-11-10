<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/files', 'as' => 'admin.files.'], function () {
    Route::post('', 'Admin\FileController@store')->name('store');
});
