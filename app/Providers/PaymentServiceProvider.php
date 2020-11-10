<?php

namespace App\Providers;

use App\Exceptions\PaymentNotFoundException;
use App\Models\Admin\StoreBraspag;
use App\Models\Admin\StoreCielo;
use App\Models\Admin\StoreAzul;
use App\Models\GlobalStatus;
use App\Payments\Interfaces\IPaymentMethod;
use App\Payments\MainPaymentMethod;
use App\Payments\Braspag\Braspag;
use App\Payments\Cielo\Cielo;
use App\Payments\Paypal\Paypal;
use App\Payments\Azul\Azul;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IPaymentMethod::class, function ($app) {
            $id_payment = $app->request->all()['id_payment'];
            switch($id_payment){
                case MainPaymentMethod::GATEWAY_BRASPAG;
                    $sb = StoreBraspag::whereIdStore($app->request->all()['id_store'])
                    ->join('stores as s', 's.id', '=', 'stores_braspag.id_store')
                    ->join('clients_payments as cp', 'cp.id_client', '=', 's.id_client')
                    ->where('cp.status', '=', GlobalStatus::STATUS_ACTIVE)
                    ->first();

                    if($sb)
                    {
                        return new Braspag($sb->merchant_id, $sb->merchant_key);
                    }

                case MainPaymentMethod::GATEWAY_CIELO;

                    $sc = StoreCielo::whereIdStore($app->request->all()['id_store'])
                    ->join('stores as s', 's.id', '=', 'stores_cielo.id_store')
                    ->join('clients_payments as cp', 'cp.id_client', '=', 's.id_client')
                    ->where('cp.status', '=', GlobalStatus::STATUS_ACTIVE)
                    ->first();

                    if($sc)
                    {
                        return new Cielo($sc->merchant_id, $sc->merchant_key);
                    }

                case MainPaymentMethod::GATEWAY_AZUL:
                     $sa = StoreAzul::whereIdStore($app->request->all()['id_store'])
                    ->join('stores as s', 's.id', '=', 'stores_azul.id_store')
                    ->join('clients_payments as cp', 'cp.id_client', '=', 's.id_client')
                    ->where('cp.status', '=', GlobalStatus::STATUS_ACTIVE)
                    ->first();

                    if($sa)
                    {
                        return new Azul($sa->merchant_id, $sa->merchant_key);
                    }

                case MainPaymentMethod::GATEWAY_LUKA:


                case MainPaymentMethod::GATEWAY_PAYPAL;
                    //return new Paypal();

                default:
                    return new PaymentNotFoundException();
                break;
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
