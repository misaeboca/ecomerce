<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product;
use App\Models\GlobalStatus;
use Illuminate\Validation\Rule;
use App\Http\Requests\Admin\JsonFormRequest;

class StatusRequest extends JsonFormRequest
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
            'product' => [
                'required',
                'max:30',
                function ($attribute, $value, $fail) {
                    if(Product::whereSku($value)->count() <= 0) {
                        $fail('unique.sku');
                        return;
                    }
                },
            ],
            /*'status' => [
                'required',
                Rule::in([GlobalStatus::STATUS_ACTIVE, GlobalStatus::STATUS_ACTIVE])
            ]*/
        ];
    }
}
