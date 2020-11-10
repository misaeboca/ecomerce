<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Compra Realizada</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
        <?php
             $store = App\Models\Admin\Store::whereId($data['id_store'])->first();
             $customer = App\Models\Admin\Customer::whereId($data['id_customer'])->first();
             $customerAdress = App\Models\Admin\CustomerAddress::whereId($data['id_customer'])->first();
             $order = App\Models\Admin\Order::whereId($data['id'])->with('products')->first();
             $payment = App\Models\Admin\Payment::whereId($data['id_payment'])->first();
             $delivery = App\Models\Admin\Delivery::whereId($data['id_delivery'])->first();
        ?>

        <!-- Store Data -->
        <div>
            Store: {{ $store->name}}
            City: {{ $store->city}}
            Address: {{ $store->address}}
            Email: {{ $store->email}}
            Phone: {{ $store->phone}}
            Site: <a href="http://{{ $store->domain}}" target="_blank">{{ $store->domain}}</a>
        </div>

        <!-- Customer Data -->
        <div>
            Customer: {{ $customer->name . ' ' . $customer->lastname }}
            Cpf: {{ $customer->cpf }}
            Phone: {{ $customer->phone }}
        </div>

        <!-- Order Data -->
        <div>
            Order: {{ $order->id}}
            Fecha de Compra: {{ $order->created_at}}
            Status: {{ $order->status}}
            Subtotal: {{ $order->subtotal}}
            Delivery: @if($order->delivery_cost > 0) {{ $order->delivery_cost}} @else Gratis @endif
            Total: {{ $order->total}}

            @foreach($order->products as $prod)
                <?php $p = App\Models\Admin\Product::whereSku($prod->product)->first(); ?>
                Product Name: {{$p->name}}
                Sku: {{$prod->product}}@if($p->cod != 'u')-{{$p->cod}}{{$p->sku}}@endif
                Quantity: {{$prod->quantity}}
            @endforeach
        </div>

    <!-- Payment Data -->
    <div>
        GateWay: {{ $payment->name}}
    </div>

    <!-- Delivery Data -->
    <div>
        @if(!is_null($delivery))
            GateWay: {{ $delivery->name}}
            Street: {{$customerAdress->street}}
            Number:  {{$customerAdress->number}}
            Complement: {{$customerAdress->complement}}
            ZipCode:  {{$customerAdress->zip_code}}
            City:  {{$customerAdress->city}}
            State:  {{$customerAdress->state}}
        @endif
    </div>

    </body>
</html>
