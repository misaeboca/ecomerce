<?php

namespace App\Http\Requests\Common\Order;

use App\Models\Common\Delivery;
use App\Models\Common\Store;
use App\Http\Requests\Common\JsonFormRequest;

class CostRequest extends JsonFormRequest
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
            'id_delivery' => [
                'sometimes',
                function ($attribute, $value, $fail) {
                    if( !isset($value) ) {
                        $fail('invalid.id_delivery');
                        return;
                    }
                    else if(Delivery::whereId($value)->count() <= 0) {
                        $fail('invalid.id_delivery');
                        return;
                    }
                },
            ],
            'address' => [
                'required',
                function ($attribute, $value, $fail) {
                    if( isset($value) ) {
                        if(!isset($value['street'])) {
                            $fail('address.invalid.street');
                            return;
                        }

                        if(!isset($value['number'])) {
                            $fail('address.invalid.number');
                            return;
                        }

                        if(!isset($value['cep'])) {
                            $fail('address.invalid.cep');
                            return;
                        }

                        if(!isset($value['city'])) {
                            $fail('address.invalid.city');
                            return;
                        }

                        if(!isset($value['state'])) {
                            $fail('address.invalid.state');
                            return;
                        }

                        if(!isset($value['country'])) {
                            $fail('address.invalid.country');
                            return;
                        }

                        if(!isset($value['district'])) {
                            $fail('address.invalid.district');
                            return;
                        }
                    }

                },
            ],
            'cost' => [
                'required',
                'numeric'
            ]
        ];
    }
}
