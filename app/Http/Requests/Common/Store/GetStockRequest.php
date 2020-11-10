<?php

namespace App\Http\Requests\Common\Store;

use App\Http\Requests\Common\JsonFormRequest;
use App\Models\Admin\Product;
use App\Models\Admin\Store;

class GetStockRequest extends JsonFormRequest
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
            'id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(Store::whereId($value)->count() < 1) {
                        $fail('invalid.id');
                    }
                },
            ],
            'sku' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(Product::whereSku($value)->count() < 1) {
                        $fail('invalid.sku');
                    }
                },
            ],
        ];
    }
}
