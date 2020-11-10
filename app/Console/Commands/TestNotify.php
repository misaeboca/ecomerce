<?php

namespace App\Console\Commands;

use App\Models\Admin\Order;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class TestNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ntest';

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
        try {
            $order = Order::with(['delivery', 'payment', 'customer', 'products', 'address'])->first();

            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);

            $products = [];
            foreach($order->products as $product)
            {
                $products [] = [
                    "sku" => $product->product,
                    "quantity" => $product->quantity
                ];
            }

            logError('https://portal.lanlimp.com.br/api/L5f2b0174806b1/order/');
                $data= [
                    "name" => $order->customer->name . ' ' . $order->customer->lastname ,
                    "cpfcnpj" => $order->customer->cpf,
                    "identity" => 11111111111,
                    "phone" => $order->customer->phone,
                    "email" => $order->customer->email,
                    "street" => $order->customer->street,
                    "house_number" => "10a",
                    "complement" => $order->customer->address->complement,
                    "neighborhood" => $order->customer->address->street,
                    "city" => $order->customer->address->city,
                    "state" => $order->customer->address->state,
                    "cep" => 111111111,
                    "country" => "BRA",
                    "observation" => $order->observation,
                    "payment" => "creditcard",
                    "id_order" => $order->id,
                    "id_order_custommer" => 11111111,
                    "date_order" => $order->created_at,
                    "delivery_price" => 0.00,
                    "products" => [
                        [
                            "sku" => "8eQHFzsjKVA42v5UbISJBn9JXai4Sb",
                            "quantity" => 10
                        ]
                    ]
                ];
            logInfo($data);
            $response = $client->post('https://portal.lanlimp.com.br/api/L5f2b0174806b1/order/',$data);

            $body = json_decode($response->getBody());
            ($body);
        } catch (\Exception $e)
        {
            logError($e->getMessage());
            return 0;
        }
        echo 'finish' . PHP_EOL;
        return 0;
    }
}
