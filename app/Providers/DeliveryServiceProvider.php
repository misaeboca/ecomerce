<?php

namespace App\Providers;

use App\Deliveries\Interfaces\IDeliveryMethod;
use App\Deliveries\Loggi\Loggi;
use App\Deliveries\MainDeliveryMethod;
use App\Exceptions\DeliveryNotFoundException;
use App\Models\Admin\Store;
use Illuminate\Support\ServiceProvider;


class DeliveryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IDeliveryMethod::class, function ($app) {
            $udc = $app->request->input('udc_slug');
            $usc = $app->request->input('id_store');
            $free_amount = $app->request->input('free_amount', 1000000);

            switch($udc)
            {
                case MainDeliveryMethod::DELIVERY_LOGGI;
                    $store = Store::whereId($usc)->with('loggi')->first();
                    return new Loggi($store->loggi->user, $store->loggi->api_key, $store->loggi->shop, $store->loggi_address, $store->loggi->distance, $free_amount);
                default:
                    return new Loggi(null);
                    //return new DeliveryNotFoundException();
            }
         });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
