<?php

namespace App\Http\Requests\Admin\Order;

use App\Models\Admin\Order;
use App\Http\Requests\Admin\JsonFormRequest;

class TrashRequest extends JsonFormRequest
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
                function ($attribute, $value, $fail) {
                    if(Order::whereId($value)->count() < 1) {
                        $fail('invalid.id_order');
                        return;
                    }
                },
            ],
        ];
    }
}
