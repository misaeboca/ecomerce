<?php

namespace App\Providers;

use App\Clients\Frigidaire\Frigidaire;
use App\Clients\Interfaces\IClientMethod;
use App\Clients\Lanlimp\Lanlimp;
use App\Clients\MainClientMethod;
use App\Clients\Pandora\Pandora;
use App\Exceptions\ClientNotFoundException;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IClientMethod::class, function ($app) {
            $id  = $app->request->input('id_client');

            switch($id)
            {
                case MainClientMethod::CLIENT_PANDORA;
                    return new Pandora();
                case MainClientMethod::CLIENT_LANLIMP;
                    return new Lanlimp();
                case MainClientMethod::CLIENT_FRIGIDAIRE;
                    return new Frigidaire();
                default:
                    //return new Pandora();
                    throw new ClientNotFoundException();
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
