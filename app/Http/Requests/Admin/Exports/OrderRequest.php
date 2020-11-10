<?php

namespace App\Http\Requests\Admin\Exports;

use App\Http\Requests\Admin\JsonFormRequest;

class OrderRequest extends JsonFormRequest
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
            'start_date' => [
                'date_format:Y-m-d',
                 function ($attribute, $value, $fail) {
                    if(empty($value)) {
                        $fail('invalid.star_date');
                    }
                },

            ],
            'end_date' => [
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    if(empty($value)) {
                        $fail('invalid.star_date');
                    }
                },
            ],

            'id_store' => [
                'string',
                function ($attribute, $value, $fail) {
                    if(empty($value)) {
                        $fail('invalid.id_store');
                    }
                },
            ],

            'id_seller' => [
                'string',
                function ($attribute, $value, $fail) {
                    if(empty($value)) {
                        $fail('invalid.id_seller');
                    }
                },
            ],
            'id_payment' => [
                'string',
                function ($attribute, $value, $fail) {
                    if(empty($value)) {
                        $fail('invalid.id_payment');
                    }
                },
            ],
            'id_customer' => [
                'string',
                function ($attribute, $value, $fail) {
                    if(empty($value)) {
                        $fail('invalid.id_payment');
                    }
                },
            ],
            'id_delivery' => [
                'string',
                function ($attribute, $value, $fail) {
                    if(empty($value)) {
                        $fail('invalid.id_delivery');
                    }
                },
            ],
        ];
    }
}
