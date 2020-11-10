<?php

use Illuminate\Support\Facades\Route;

Route::post('authenticate', 'Admin\Auth\LoginController@authenticate')->name('authenticate');

require(__DIR__ . '/products.php');

require(__DIR__ . '/orders.php');

require(__DIR__ . '/payments.php');

require(__DIR__ . '/deliveries.php');

require(__DIR__ . '/banners.php');

require(__DIR__ . '/stores.php');

require(__DIR__ . '/shares.php');

require(__DIR__ . '/categories.php');

require(__DIR__ . '/materials.php');

require(__DIR__ . '/themes.php');

require(__DIR__ . '/clicks.php');

require(__DIR__ . '/home.php');

require(__DIR__ . '/cartsshares.php');

require(__DIR__ . '/promotions.php');
