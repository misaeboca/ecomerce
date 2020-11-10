<?php

namespace App\Http\Requests\Admin\Order;

use App\Models\Admin\Delivery;
use App\Models\Admin\Payment;
use App\Models\Admin\Product;
use App\Models\Admin\Share;
use App\Models\Admin\Store;
use App\Http\Requests\Admin\JsonFormRequest;


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
