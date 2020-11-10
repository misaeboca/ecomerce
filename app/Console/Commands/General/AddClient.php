<?php

namespace App\Console\Commands\General;

use App\Models\Admin\Client as ClientModel;
use App\Models\Admin\ClientDelivery;
use App\Models\Admin\ClientPayment;
use App\Models\Admin\ClientShortener;
use App\Models\Admin\Delivery;
use App\Models\Admin\Payment;
use Illuminate\Console\Command;

class AddClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:client {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adding new client';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clientName = $this->argument('name');

        try
        {
            if(ClientModel::whereName($clientName)->count() == 0)
            {
                $client = ClientModel::create([
                    'name' => $clientName,
                    'id' => generateSlug($clientName),
                    'slug' => generateSlug($clientName)
                ]);

                $allPayments = Payment::all();

                foreach($allPayments as $payment)
                {
                    ClientPayment::create([
                        'id_payment' => $payment->slug,
                        'id_client' => $client->slug
                    ]);
                }

                $allDeliveries = Delivery::all();

                foreach($allDeliveries as $delivery)
                {
                    ClientDelivery::create([
                        'id_delivery' => $delivery->slug,
                        'id_client' => $client->slug
                    ]);
                }

                ClientShortener::create([
                    'id_client' => $client->slug,
                    'api_key' => 'change_me'
                ]);

                echo 'client ' . $clientName . ' added'. PHP_EOL;
            }
            else {
                echo 'client ' . $clientName . ' already exist'. PHP_EOL;
            }
            return 0;
        } catch(\Exception $e)
        {
            logError('client ' . $clientName . 'not added: ' . $e->getMessage());
            echo 'client ' . $clientName . 'not added: ' . $e->getMessage() . PHP_EOL;
            return 0;
        }

    }
}
