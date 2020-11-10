<?php

namespace App\Http\Requests\Common\Order;

use App\Models\Common\Delivery;
use App\Models\Common\Payment;
use App\Models\Common\Product;
use App\Models\Common\Share;
use App\Models\Common\Store;
use App\Http\Requests\Common\JsonFormRequest;


class AddCustomerRequest extends JsonFormRequest
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
                function ($attribute, $value, $fail)
                {

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
                },
            ],
        ];
    }
}
