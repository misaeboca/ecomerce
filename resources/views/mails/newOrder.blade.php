<!DOCTYPE html>
<html>
<head>
	<title>Su pedido</title>
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
	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:auto; max-width: 600px; font-family: Arial, Helvetica, sans-serif">
		<tr>
			<td>
				<table  border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 20px">
					<tr>
						<td width="180" style="text-align: left">
							<img src="http://adminpandora.flexystore.com/assets/img/Pandora-Logo.png" alt="company logo" style="height: 100%; width: 170px; margin-top: -22px;">
						</td>
						<td style="text-align: right;">
							{{ $store->name }}<br>
							{{ $store->sigla }}<br>
							{{ $store->address }}<br>
                            {{ $store->city }}<br>
                            {{ $store->phone }}<br>
                            {{ $store->email }}<br>
                            <a href="http://{{ $store->domain}}" target="_blank">{{ $store->domain}}</a><br>
						</td>
					</tr>
                </table>

				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 20px">
					<tr>
						<td>
							<strong>Orden</strong><br>
							#{{ $order->id}}
						</td>
						<td style="white-space: nowrap;">
							<strong>Valor total</strong><br>
							R$ {{ $order->total}}
						</td>
						<td style="text-align: right;">
							<strong>Estado</strong><br>
							{{ $order->status}}
                        </td>
                        <td style="text-align: right;">
							<strong>Delivery</strong><br>
							@if($order->delivery_cost > 0) {{ $order->delivery_cost}} @else Gratis @endif
						</td>
					</tr>
                </table>

				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 20px">
					<tbody>
						<tr>
							<td>
								<strong>Entregar a</strong><br>
								{{ $customer->name . ' ' . $customer->lastname }}<br>
                                {{ $customer->email }}<br>
                                {{ $customer->phone }}<br>
							</td>
							<td style="text-align: right;">
								<strong>Fecha:</strong> 9/24/20, 2:36 PM
							</td>
						</tr>
					</tbody>
				</table>
			</td>

		</tr>


		<tr>

			<td>


				<table border="0" cellpadding="10" cellspacing="0" width="100%" style="text-align: center; margin-bottom: 20px">
					<thead>
						<tr>
							<th style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc">#</th>
							<th style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc">Producto &amp; Descripciòn</th>
							<th style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc">Precio</th>
							<th style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc">Cantidad</th>
							<th style="border-top: 1px solid #ccc; border-bottom: 1px solid #ccc">Total</th>
						</tr>
					</thead>
					<tbody>
                        @foreach($order->products as $prod)
                            <?php $p = App\Models\Admin\Product::whereSku($prod->product)->first(); ?>

                            <tr>
                                <th style="border-bottom: 1px solid #ccc">1</th>
                                <td style="text-align: left; border-bottom: 1px solid #ccc">
                                    {{$p->name}} | {{$prod->product}}@if($p->cod != 'u')-{{$p->cod}}{{$p->sku}}@endif
                                </td>
                                <td style="white-space: nowrap; border-bottom: 1px solid #ccc">R$ {{$prod->price}}</td>
                                <td style="border-bottom: 1px solid #ccc"> {{$prod->quantity}}</td>
                                <td style="white-space: nowrap; border-bottom: 1px solid #ccc">R$  {{$prod->quantity * $prod->price}}</td>
                            </tr>
                        @endforeach
					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<td></td>
							<th style="white-space: nowrap;">Total</th>
							<td></td>
							<th style="white-space: nowrap;">R$ {{ $order->total}}</th>
						</tr>
					</tfoot>
				</table>
                <?php
                    $prp = json_decode($order->payment_response_process);
                ?>

				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td valign="top">
							<h3 style="margin-bottom: 0; padding-bottom: 0">Metodo de pago:</h3>
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tbody>
									<tr>
										<td>Braspag</td>
									</tr>
									<tr>
										<td><strong>Authorization Code:</strong> {{$prp->authorizationCode}}</td>
									</tr>
									<tr>
										<td><strong>Installments:</strong> {{$prp->installments}}</td>
									</tr>
									<tr>
										<td><strong>paymentId:</strong> {{$prp->paymentId}}</td>
									</tr>
									<tr>
										<td><strong>proofOfSale:</strong> {{$prp->proofOfSale}}</td>
									</tr>
									<tr>
										<td><strong>Card:</strong> {{$prp->cardNumber}}</td>
									</tr>
								</tbody>
							</table>


						</td>
						<td valign="top">
							<h3 style="margin-bottom: 0; padding-bottom: 0">Metodo de envio:</h3>
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tbody>
									<tr>
										<td>Pickup</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</table>



			</td>
		</tr>
	</table>
</body>
</html>
