<?php

namespace App\Http\Requests\Admin\Order;

use App\Models\Admin\Order;
use App\Http\Requests\Admin\JsonFormRequest;

class PaymentRequest extends JsonFormRequest
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
            'id_order' => [
                'required',
                'max:30',
                function ($attribute, $value, $fail) {
                    $order = Order::whereId($value)->whereStatus(ORDER::STATUS_PENDING)->first();
                    if(!$order) {
                        $fail('exist.id_order');
                        return;
                    }
                },
            ],
        ];
    }
}
