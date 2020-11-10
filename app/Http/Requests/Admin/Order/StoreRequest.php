<?php

namespace App\Http\Requests\Admin\Order;

use App\Models\Admin\Delivery;
use App\Models\Admin\Payment;
use App\Models\Admin\Product;
use App\Models\Admin\Share;
use App\Models\Admin\Store;
use App\Http\Requests\Admin\JsonFormRequest;


class StoreRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_store' => [
                'required',
                function ($attribute, $value, $fail) {

                    if(!isset($value)) {
                        $fail('invalid.id_store');
                        return;
                    }

                    if(Store::whereId($value)->count() <= 0) {
                        $fail('invalid.id_store');
                        return;
                    }

                },
            ],
            'payment' => [
                'required',
                function ($attribute, $value, $fail) {

                    if(!isset($value['id_payment'])) {
                        $fail('payment.invalid.upc');
                        return;
                    }

                    if(isset($value['installments']) && (($value['installments'] < 1) || ($value['installments'] > 10)) ) {
                        $fail('payment.invalid.installments');
                        return;
                    }

                    if(Payment::whereId($value['id_payment'])->count() <= 0) {
                        $fail('payment.invalid.upc');
                        return;
                    }

                    if($value['type'] == 'CreditCard' || $value['type'] == 'DebitCard') {

                        if(!isset($value['card']['cardNumber'])) {
                            $fail('payment.invalid.cardNumber');
                            return;
                        }

                        if(!isset($value['card']['holder'])) {
                            $fail('payment.invalid.holder');
                            return;
                        }

                        if(!isset($value['card']['expirationDate'])) {
                            $fail('payment.invalid.expirationDate');
                            return;
                        }

                        if(!isset($value['card']['securityCode'])) {
                            $fail('payment.invalid.securityCode');
                            return;
                        }

                        if(!isset($value['card']['brand'])) {
                            $fail('payment.invalid.brand');
                            return;
                        }

                    }
                    else {
                        $fail('invalid.payment.type');
                        return;
                    }
                },
            ],
            'products' => [
                'required',
                function ($attribute, $value, $fail) {
                    foreach($value as $v) {
                        if(!isset($v['product'])) {
                            $fail('products.invalid.product');
                            return;
                        }
                        else if(Product::whereSku($v['product'])->count() < 1) {
                            $fail('products.invalid.product');
                            return;
                        }

                        if(!isset($v['variation']) || $v['variation'] < 1) {
                            $fail('products.invalid.variation');
                            return;
                        }

                        if(!isset($v['variation']['cod'])) {
                            $fail('products.invalid.variation.cod');
                            return;
                        }

                        if(!isset($v['variation']['sku'])) {
                            $fail('products.invalid.variation.sku');
                            return;
                        }

                        if(!isset($v['variation']['quantity']) || $v['variation']['quantity'] < 1) {
                            $fail('products.invalid.variation.quantity');
                            return;
                        }
                    }

                },
            ],
            'promotions' => [
                'sometimes',
                function ($attribute, $value, $fail) {
                    foreach($value as $v) {
                        if(!isset($v['product'])) {
                            $fail('products.invalid.product');
                            return;
                        }
                        else if(Product::whereSku($v['product'])->count() < 1) {
                            $fail('products.invalid.product');
                            return;
                        }

                        if(!isset($v['variation']) || $v['variation'] < 1) {
                            $fail('products.invalid.variation');
                            return;
                        }

                        if(!isset($v['variation']['cod'])) {
                            $fail('products.invalid.variation.cod');
                            return;
                        }

                        if(!isset($v['variation']['sku'])) {
                            $fail('products.invalid.variation.sku');
                            return;
                        }

                        if(!isset($v['variation']['quantity']) || $v['variation']['quantity'] < 1) {
                            $fail('products.invalid.variation.quantity');
                            return;
                        }
                    }

                },
            ],
            'customer' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(!isset($value['name'])) {
                        $fail('customer.invalid.name');
                        return;
                    }

                    if(!isset($value['lastname'])) {
                        $fail('customer.invalid.lastname');
                        return;
                    }

                    if(!isset($value['email'])) {
                        $fail('customer.invalid.email');
                        return;
                    }

                    if(!isset($value['cpf'])) {
                        $fail('customer.invalid.cpf');
                        return;
                    }

                    if(!isset($value['phone'])) {
                        $fail('customer.invalid.phone');
                        return;
                    }

                    if(isset($value['id_delivery']) )
                    {
                        if(Delivery::whereId($value['id_delivery'])->count() <= 0) {
                            $fail('customer.invalid.id_delivery');
                            return;
                        }
                    }

                    if( isset($value['deliveryAddress']) ) {
                        if(!isset($value['deliveryAddress']['street'])) {
                            $fail('customer.deliveryAddress.invalid.street');
                            return;
                        }

                        if(!isset($value['deliveryAddress']['number'])) {
                            $fail('customer.deliveryAddress.invalid.number');
                            return;
                        }

                        if(!isset($value['deliveryAddress']['cep'])) {
                            $fail('customer.deliveryAddress.invalid.cep');
                            return;
                        }

                        if(!isset($value['deliveryAddress']['city'])) {
                            $fail('customer.deliveryAddress.invalid.city');
                            return;
                        }

                        if(!isset($value['deliveryAddress']['state'])) {
                            $fail('customer.deliveryAddress.invalid.state');
                            return;
                        }

                        if(!isset($value['deliveryAddress']['country'])) {
                            $fail('customer.deliveryAddress.invalid.country');
                            return;
                        }

                        if(!isset($value['deliveryAddress']['district'])) {
                            $fail('customer.deliveryAddress.invalid.district');
                            return;
                        }


                        /*if(!isset($value['deliveryAddress']['complement'])) {
                            $fail('customer.deliveryAddress.invalid.complement');
                            return;
                        }*/

                    }

                },
            ],
            'id_share' => [
                'sometimes',

                function ($attribute, $value, $fail) {
                    if(Share::whereUshc($value)->count() <= 0) {
                        $fail('unique.ushc');
                        return;
                    }
                },
            ],
            'id_seller' => [
                'sometimes',
                'max:5000'
            ],
            'observations' => [
                'sometimes',
                'max:5000'
            ],
        ];
    }
}
