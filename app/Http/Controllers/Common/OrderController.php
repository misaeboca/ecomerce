<?php

namespace App\Http\Controllers\Common;

use DB;
use Mail;
use App\Models\Common\Order;
use App\Models\Common\Customer;
use App\Models\Common\CustomerAddress;
use App\Models\Common\OrderProduct;
use App\Models\Common\Product;
use App\Models\Common\StoreProduct;
use App\Payments\Interfaces\IPaymentMethod;
use App\Deliveries\Interfaces\IDeliveryMethod;
use App\Clients\Interfaces\IClientMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\AddCustomerRequest;
use App\Http\Requests\Admin\Order\CostRequest;
use App\Http\Requests\Admin\Order\RefundRequest;
use App\Http\Requests\Admin\Order\StoreRequest;
use App\Mail\NewOrderMail;
use App\Mail\RefundOrderMail;
use App\Models\Admin\CustomerSeller;
use App\Models\Admin\Store;
use App\Models\Admin\StoreCustomer;
use App\Models\Common\ProductVariation;
use App\Payments\MainPaymentMethod;

class OrderController extends Controller
{

    public function getCost(CostRequest $request, IDeliveryMethod $deliveryMethod)
    {

        $data = $request->all();

        //Costo por el envio segun el metodo
        $address = $data['address']['street']  . ' ' .
                    $data['address']['number']   . ', ';

        if(isset($data['address']['complement'])) {
            $address .= $data['address']['complement']  . ', ' ;
        }

        $address .= $data['address']['district'] . ' - ' .
                    $data['address']['city'] . ' ' .
                    $data['address']['state'] . ' ' .
                    $data['address']['cep'] . ', Brasil';

        $quotation = $deliveryMethod->getQuotation(['address' => $address]);

        if($quotation['distance'] == -2) {
            DB::rollback();
            return response()->json(['state' => 'fail', 'response' => ['code' => 303]], 200);
        }

        if($quotation['distance'] > $deliveryMethod->getDistance()) {
            DB::rollback();
            return response()->json(['state' => 'fail', 'response' => ['code' => 302]], 200);
        }

        if($quotation['cost'] == -1) {
            DB::rollback();
            return response()->json(['state' => 'fail', 'response' => ['code' => 301]], 200);
        }

        if($deliveryMethod->isFree(['cost' => $data['cost']]))
        {
            return response()->json(['state' => 'success', 'response' => 0], 200);
        }

        $cost = floatval($quotation['cost']);

        return response()->json(['state' => 'success', 'response' => $cost], 200);
    }

    public function store(StoreRequest $request, IClientMethod $clientMethod, IPaymentMethod $paymentMethod, IDeliveryMethod $deliveryMethod)
    {
        DB::beginTransaction();

        $data = $request->all();
        $store = Store::whereId($request->input('id_store'))->first();
        try {
            //Datos del cliente
            if(Customer::whereEmail($data['customer']['email'])->count() <= 0)
            {
                $customer = Customer::create([
                    'id' => generateUniqueId(),
                    'name' => $data['customer']['name'],
                    'lastname' => $data['customer']['lastname'],
                    'email' => $data['customer']['email'],
                    'cpf' => $data['customer']['cpf'],
                    'phone' => $data['customer']['phone']
                ]);
            } else
            {
                $customer = Customer::whereEmail($data['customer']['email'])->first();
                $customer->update([
                    'name' => $data['customer']['name'],
                    'lastname' => $data['customer']['lastname'],
                    'cpf' => $data['customer']['cpf'],
                    'phone' => $data['customer']['phone']
                ]);
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@store@customer: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 306, 'msg' => 'invalid.customer']], 401);
        }

        try {
            $customerDeliveryAddress = null;
            if(isset($data['customer']['address']))
            {
                if(isset($data['customer']['address']['current']))
                {
                    $customerDeliveryAddress = CustomerAddress::whereId($data['customer']['address']['current'])->first();
                } else
                {
                    $customerDeliveryAddress = CustomerAddress::create([
                        'id' => generateUniqueId(),
                        'id_customer' => $customer->id,
                        'type' => 'address',
                        'street' => isset($data['customer']['address']['street']) ? $data['customer']['address']['street'] : null,
                        'number' => isset($data['customer']['address']['number']) ? $data['customer']['address']['number'] : null,
                        'complement' => isset($data['customer']['address']['complement']) ? $data['customer']['address']['complement'] : null,
                        'zip_code' => isset($data['customer']['address']['zip_code']) ? $data['customer']['address']['zip_code'] : null,
                        'city' => isset($data['customer']['address']['city']) ? $data['customer']['address']['city'] : null,
                        'state' => isset($data['customer']['address']['state']) ? $data['customer']['address']['state'] : null,
                        'country' => isset($data['customer']['address']['country']) ? $data['customer']['address']['country'] : null,
                        'district' => isset($data['customer']['address']['district']) ? $data['customer']['address']['district'] : null,
                        'cep' => isset($data['customer']['address']['cep']) ? $data['customer']['address']['cep'] : null,
                        'endereco' => isset($data['customer']['address']['endereco']) ? $data['customer']['address']['endereco'] : null,
                        'neighborhood' => isset($data['customer']['address']['neighborhood']) ? $data['customer']['address']['neighborhood'] : null,
                    ]);
                }
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@store@customerDelivery: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 307, 'msg' => 'invalid.customer.delivery']], 401);
        }

        try {
            if(isset($data['id_seller']))
            {
                if(CustomerSeller::whereIdSeller($data['id_seller'])->whereIdCustomer($customer->id)->count() <= 0)
                {
                    CustomerSeller::create([
                        'id_customer' => $customer->id,
                        'id_seller' => $data['id_seller']
                    ]);
                }
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@store@seller: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 308, 'msg' => 'invalid.id_seller']], 401);
        }

        try {
            if(StoreCustomer::whereIdStore($store->id)->whereIdCustomer($customer->id)->count() <= 0)
            {
                StoreCustomer::create([
                    'id_customer' => $customer->id,
                    'id_store' => $store->id
                ]);
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@store@StoreCustomer: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 310, 'msg' => 'invalid.store']], 401);
        }

        try {
            $merchantOrderId = generateUniqueId();
            $order = Order::create([
                'id' => $merchantOrderId,
                'id_store' => $store->id,
                'id_share' => isset($data['id_share']) ? $data['id_share'] : null,//unique share code
                'id_delivery' => isset($data['customer']['id_delivery']) ? $data['customer']['id_delivery'] : null,//unique delivery code
                'id_payment' => $data['id_payment'],//unique payment code
                'id_customer' => $customer->id,//unique customer code
                'id_customer_address' => isset($customerDeliveryAddress->id) ? $customerDeliveryAddress->id : null,
                'status' => ORDER::STATUS_PENDING,
                'observations' => isset($data['observations']) ? $data['observations'] : null,
                'register_date' => date('Y-m-d')
            ]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@store@create: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 311, 'msg' => 'invalid.order']], 401);
        }

        try {
            $total = 0;
            foreach($data['products'] as $product)
            {
                $sp = StoreProduct::whereProduct($product['product'])->whereIdStore($store->id)->first();
                $stock = $clientMethod->verifyStock([
                    'sku' => (($product['variation']['sku'] == 'U' || $product['variation']['sku'] == 'u') ? $product['product'] : $product['product'] . '-' . $product['variation']['sku'] . $product['variation']['cod']),
                    'store' => $store->id
                ]);

                if($sp == null)
                {
                    logError('OrderController@store: ' . 'store: ' . $store->id . ' product not assigned: ' . $product['sku']);
                    DB::rollback();
                    return response()->json(['state' => 'fail', 'msg' => 'product not assigned'], 401);
                } else if(($stock > 0) && ($stock >= $product['variation']['quantity']))
                {
                    logInfo('si stock');
                    logInfo($product['product']);
                    $pv = ProductVariation::whereProduct($product['product'])
                    ->whereCod($product['variation']['cod'])
                    ->whereSku($product['variation']['sku'])
                    ->first();
                    logInfo($pv);
                    $t = ($product['variation']['quantity'] * $pv['price']);
                    OrderProduct::create([
                        'id_order' => $order['id'],
                        'product' => $product['product'],
                        'cod' => $product['variation']['cod'],
                        'sku' => $product['variation']['sku'],
                        'price' => $pv['price'],
                        'quantity' => $product['variation']['quantity'],
                        'task' => '0.00',
                        'discount'=> '0.00',
                        'total' => $t . ''
                    ]);
                    $total += $t;
                    $sp->update(['stock' => $sp['stock'] - $product['variation']['quantity']]);
                } else
                {
                    logError('OrderController@store: ' . 'store: ' . $store->id_store . ' is out of stock');
                    logError('product: ' . $product['product']);
                    DB::rollback();
                    return response()->json(['state' => 'fail', 'response' => ['code' => 304] ], 200);
                }
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@store@products: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 312, 'msg' => 'invalid.products']], 401);
        }

        try {
            if(isset($data['promotions']))
            {
                foreach($data['promotions'] as $product)
                {
                    $sp = StoreProduct::whereProduct($product['product'])->whereIdStore($store->id)->first();

                    $stock = $clientMethod->verifyStock([
                        'sku' => (($product['variation']['sku'] == 'U' || $product['variation']['sku'] == 'u') ? $product['product'] : $product['product'] . '-' . $product['variation']['sku'] . $product['variation']['cod']),
                        'store' => $store->id
                    ]);
                    $stock = 10 ;
                    if($sp == null)
                    {
                        logError('OrderController@store: ' . 'store: ' . $store->id . ' product not assigned: ' . $product['sku']);
                        DB::rollback();
                        return response()->json(['state' => 'fail', 'msg' => 'product not assigned'], 401);
                    } else if(($stock > 0) && ($stock >= $product['variation']['quantity']))
                    {
                        $p = Product::whereSku($product['product'])->first();
                        $pv = ProductVariation::whereProduct($product['product'])
                        ->whereCod($product['variation']['cod'])
                        ->whereSku($product['variation']['sku'])
                        ->first();

                        OrderProduct::create([
                            'id_order' => $order['id'],
                            'product' => $product['product'],
                            'cod' => $product['variation']['cod'],
                            'sku' => $product['variation']['sku'],
                            'price' => 0,
                            'quantity' => $product['variation']['quantity'],
                            'task' => '0.00',
                            'discount'=> '0.00',
                            'total' => $t . ''
                        ]);

                        $sp->update(['stock' => $sp['stock'] - $product['variation']['quantity']]);
                    } else
                    {
                        logError('OrderController@store: ' . 'store: ' . $store->id_store . ' is out of stock');
                        logError('OrderController@store: ' . 'product: ' . $product['product']);
                        DB::rollback();
                        return response()->json(['state' => 'fail', 'response' => ['code' => 304] ], 200);
                    }
                }
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@store@promotions: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 313, 'msg' => 'invalid.']], 401);
        }

        try {
            $deliveryCost = 0.0;
            $quotation = null;
            $address = null;

            if(isset($data['customer']['id_delivery']))
            {
                if(isset($data['customer']['deliveryAddress']['current']))
                {
                    $customerDeliveryAddress = CustomerAddress::whereId($data['customer']['deliveryAddress']['current'])->first();
                } else
                {
                    $customerDeliveryAddress = CustomerAddress::create([
                        'id' => generateUniqueId(),
                        'id_customer' => $customer->id,
                        'type' => 'delivery',
                        'street' => isset($data['customer']['deliveryAddress']['street']) ? $data['customer']['deliveryAddress']['street'] : null,
                        'number' => isset($data['customer']['deliveryAddress']['number']) ? $data['customer']['deliveryAddress']['number'] : null,
                        'complement' => isset($data['customer']['deliveryAddress']['complement']) ? $data['customer']['deliveryAddress']['complement'] : null,
                        'zip_code' => isset($data['customer']['deliveryAddress']['zip_code']) ? $data['customer']['deliveryAddress']['zip_code'] : null,
                        'city' => isset($data['customer']['deliveryAddress']['city']) ? $data['customer']['deliveryAddress']['city'] : null,
                        'state' => isset($data['customer']['deliveryAddress']['state']) ? $data['customer']['deliveryAddress']['state'] : null,
                        'country' => isset($data['customer']['deliveryAddress']['country']) ? $data['customer']['deliveryAddress']['country'] : null,
                        'district' => isset($data['customer']['deliveryAddress']['district']) ? $data['customer']['deliveryAddress']['district'] : null,
                        'cep' => isset($data['customer']['deliveryAddress']['cep']) ? $data['customer']['deliveryAddress']['cep'] : null,
                        'endereco' => isset($data['customer']['deliveryAddress']['endereco']) ? $data['customer']['deliveryAddress']['endereco'] : null,
                        'neighborhood' => isset($data['customer']['deliveryAddress']['neighborhood']) ? $data['customer']['deliveryAddress']['neighborhood'] : null,
                    ]);
                }

                if(!$deliveryMethod->isFree(['cost' => $total]))
                {
                    //Costo por el envio segun el metodo
                    $address = $data['customer']['deliveryAddress']['street']  . ' ' .
                            $data['customer']['deliveryAddress']['number']   . ', ';

                    if(isset($data['customer']['deliveryAddress']['complement']))
                    {
                        $address .= $data['customer']['deliveryAddress']['complement']  . ', ' ;
                    }

                    $address .= $data['customer']['deliveryAddress']['district'] . ' - ' .
                            $data['customer']['deliveryAddress']['city'] . ' ' .
                            $data['customer']['deliveryAddress']['state'] . ' ' .
                            $data['customer']['deliveryAddress']['cep'] . ', Brasil';

                    $quotation = $deliveryMethod->getQuotation([ 'address' => $address]);

                    if($quotation['distance'] == -2) {
                        DB::rollback();
                        return response()->json(['state' => 'fail', 'response' => ['code' => 303]], 200);
                    }

                    if($quotation['distance'] > $deliveryMethod->getDistance()) {
                        DB::rollback();
                        return response()->json(['state' => 'fail', 'response' => ['code' => 302]], 200);
                    }

                    if($quotation['cost'] == -1) {
                        DB::rollback();
                        return response()->json(['state' => 'fail', 'response' => ['code' => 301]], 200);
                    }

                    $deliveryCost = floatval($quotation['cost']);
                }

                $order->update([
                    'id_customer_address' => $customerDeliveryAddress->id
                ]);
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@store@create: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 314, 'msg' => 'invalid.']], 401);
        }

        try
        {
            switch($paymentMethod->getPaymentName())
            {
                case MainPaymentMethod::GATEWAY_BRASPAG :
                    $paymentMethod->setCredentials([
                        /*"Code" => "9999999",
                        "Key" =>  "D8888888",
                        "Password" => "LOJA9999999",
                        "Username" => "#Braspag2018@NOMEDALOJA#",
                        "Signature" => "001"*/
                    ]);
                break;

                case MainPaymentMethod::GATEWAY_CIELO :
                    $paymentMethod->setCredentials([
                    ]);
                break;

                case MainPaymentMethod::GATEWAY_LUKA :
                    $paymentMethod->setCredentials([

                    ]);
                break;

                case MainPaymentMethod::GATEWAY_AZUL :
                    $paymentMethod->setCredentials([

                    ]);
                break;
            }

            $paymentMethod->setOrder($order)
            ->setCustomer($customer);

            if($customerDeliveryAddress)
            {
                $paymentMethod->setCustomerDeliveryAddress($customerDeliveryAddress);
            }

            $paymentMethod->setPayment([
                'Amount' => $total + $deliveryCost,
                'Provider' => 'Simulado',
            ])
            ->setInstallments(isset($data['payment']['installments']) ? $data['payment']['installments'] : null)
            ->setInterest(isset($data['payment']['interest']) ? $data['payment']['interest'] : null);

            if($data['payment']['type'] == 'CreditCard')
            {
                $paymentMethod->setCreditCard([
                    'expirationDate' => $data['payment']['card']['expirationDate'],
                    'cardNumber' => $data['payment']['card']['cardNumber'],
                    'holder' => $data['payment']['card']['holder'],
                    'securityCode' => $data['payment']['card']['securityCode'],
                    'brand' => $data['payment']['card']['brand']
                ]);
            } else if($data['payment']['type'] == 'DebitCard')
            {
                $paymentMethod->setDebitCard([
                    'expirationDate' => $data['payment']['card']['expirationDate'],
                    'cardNumber' => $data['payment']['card']['cardNumber'],
                    'holder' => $data['payment']['card']['holder'],
                    'securityCode' => $data['payment']['card']['securityCode'],
                    'brand' => $data['payment']['card']['brand']
                ]);
            }

            $paymentMethod->create();
            if($paymentMethod->getStatusCode() == 200)
            {
                $body = $paymentMethod->getResponse();

                if($body['ReasonCode'] > -1) {
                    $order->update(
                        [
                            'payment_response' => $body['payment_response'],
                            'payment_response_process' => $body['payment_response_process'],
                            'status' => Order::STATUS_APPROVED,
                            'subtotal' => $total . '',
                            'total' => ($total + $deliveryCost) . '',
                            'delivery_cost' => $deliveryCost,
                        ]);
                    DB::commit();
                }

                DB::rollback();
                logError('OrderController@store@payment: ' . $body['ReturnMessage'] . ' - ' . $body['ProviderReturnCode']);
            }
            else {
                return response()->json(['state' => 'fail', 'response' => $paymentMethod->getResponse()], 200);
            }

        } catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@store@payment: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 305]], 401);
        }

        //si llego aqui es porque se aprobo el pago y el flujo debe seguir
        try {
            $ord = Order::whereId($order->id)->with(['delivery', 'payment', 'customer', 'products'])->first();
            $clientMethod->notifyOrder($ord);
        }
        catch (\Exception $e)
        {
            logError('OrderController@nofiyOrder: ' . $e->getMessage() . ' order_id: ' . $order->id);
        }

        try {
            Mail::to($ord->customer->email)->bcc($store->email)->send(new NewOrderMail($order));
        }
        catch (\Exception $e)
        {
            logError('OrderController@mail: ' . $e->getMessage() . ' order_id: ' . $order->id);
        }

        return response()->json(['state' => 'success', 'response' => ['order' => $order->id, 'returnMessage' => $body['ReturnMessage']]], 200);
    }

    public function addCustomer(AddCustomerRequest $request)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();
            $id_store = $request->input('id_store');

            //Datos del cliente
            if(Customer::whereEmail($data['customer']['email'])->count() <= 0)
            {
                $customer = Customer::create([
                    'id' => generateUniqueId(),
                    'name' => $data['customer']['name'],
                    'lastname' => $data['customer']['lastname'],
                    'email' => $data['customer']['email'],
                    'cpf' => $data['customer']['cpf'],
                    'phone' => $data['customer']['phone']
                ]);
            } else
            {
                $customer = Customer::whereEmail($data['customer']['email'])->first();
                $customer->update([
                    'name' => $data['customer']['name'],
                    'lastname' => $data['customer']['lastname'],
                    'cpf' => $data['customer']['cpf'],
                    'phone' => $data['customer']['phone']
                ]);
            }

            if(isset($data['id_seller']))
            {
                if(CustomerSeller::whereIdSeller($data['id_seller'])->whereIdCustomer($customer->id)->count() <= 0)
                {
                    CustomerSeller::create([
                        'id_customer' => $customer->id,
                        'id_seller' => $data['id_seller']
                    ]);
                }
            }

            if(StoreCustomer::whereIdStore($id_store)->whereIdCustomer($customer->id)->count() <= 0)
            {
                StoreCustomer::create([
                    'id_customer' => $customer->id,
                    'id_store' => $id_store
                ]);
            }
            DB::commit();
            return response()->json(['state' => 'success', 'response' => $customer], 200);

        } catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@createtCustomer: ' . $e->getMessage());
            return response()->json(['state' => 'fail',  'response' => ['code' => 304]], 401);
        }
    }

    public function refund(RefundRequest $request, IPaymentMethod $paymentMethod, IClientMethod $clientMethod)
    {
        DB::beginTransaction();
        try
        {
            $data = $request->all();
            $order = Order::whereId($data['id_order'])->with(['delivery', 'payment', 'customer', 'products'])->first();
            $store = Store::whereId($data['id_store'])->first();

            switch($paymentMethod->getPaymentName())
            {
                case MainPaymentMethod::GATEWAY_BRASPAG :
                    $paymentMethod->setCredentials([
                        /*"Code" => "9999999",
                        "Key" =>  "D8888888",
                        "Password" => "LOJA9999999",
                        "Username" => "#Braspag2018@NOMEDALOJA#",
                        "Signature" => "001"*/
                    ]);
                break;

                case MainPaymentMethod::GATEWAY_CIELO :
                    $paymentMethod->setCredentials([
                    ]);
                break;

                case MainPaymentMethod::GATEWAY_LUKA :
                    $paymentMethod->setCredentials([
                    ]);
                break;

                case MainPaymentMethod::GATEWAY_AZUL :
                    $paymentMethod->setCredentials([
                    ]);
                break;
            }

            $paymentMethod->refund($order);
            $body = $paymentMethod->getResponse();
            switch($paymentMethod->getStatusCode())
            {
                case 200:

                    if($body['ReasonCode'] > -1) {
                        $order->update(
                            [
                                'refund_response' => $body['refund_response'],
                                'refund_response_process' => $body['refund_response_process'],
                                'status' => Order::STATUS_REFUND
                            ]);
                        DB::commit();
                    }
                break;

                default:
                    DB::rollback();
                    logError('OrderController@refund: ' . $body['ReturnMessage']);
                return response()->json(['state' => 'success', 'response' => ['order' => $order->id, 'returnMessage' => $body['ReturnMessage']]], 200);
            }

        } catch (\Exception $e)
        {
            DB::rollback();
            logError('OrderController@refund: ' . $e->getMessage());
            return response()->json(['state' => 'fail', 'response' => ['code' => 305]], 401);
        }

        try {
            $clientMethod->notifyRefund($order);
        }
        catch (\Exception $e)
        {
            logError('OrderController@refund_nofiyOrder: ' . $e->getMessage() . ' order_id: ' . $order->id);
        }

        try {
            Mail::to($order->customer->email)->bcc($store->email)->send(new RefundOrderMail($order));
        }
        catch (\Exception $e)
        {
            logError('OrderController@refund_mail: ' . $e->getMessage() . ' order_id: ' . $order->id);
        }

    }

}
