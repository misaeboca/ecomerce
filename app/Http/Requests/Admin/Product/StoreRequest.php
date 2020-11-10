<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product;
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
            'name' => [
                'required',
                'max:255',
            ],
            'sku' => [
                'required',
                'max:30',
                function ($attribute, $value, $fail) {
                    if(Product::whereSku($value)->count() > 0) {
                        $fail('unique.sku');
                        return;
                    }
                },
            ],
            'type' => [
                'sometimes',
                'max:500',
            ],
            'material' => [
                'sometimes',
                'max:500'
            ],
            'theme' => [
                'sometimes',
                'max:500'
            ],
            'alternative_names' => [
                'sometimes',
                'max:500'
            ],
            'html_description' => [
                'sometimes',
                'max:5000'
            ],
            'html_short_description' => [
                'sometimes',
                'max:400'
            ],
            'tags' => [
                'sometimes',
                'max:500'
            ],
            'weight' => [
                'sometimes',
                'numeric',
            ],
            'height' => [
                'sometimes',
                'numeric'
            ],
            'width' => [
                'sometimes',
                'numeric'
            ],
            'length' => [
                'sometimes',
                'numeric',
            ],
            'title' => [
                'sometimes',
                'max:500'
            ],
            'desc' => [
                'sometimes',
                'max:500'
            ],
            'price' => [
                'required',
                'numeric'
            ],
            'sale_price' => [
                'sometimes',
                'numeric'
            ],
            'old_price' => [
                'sometimes',
                'numeric'
            ],
            'manufacturer' => [
                'sometimes',
                'max:500'
            ],
            'categories' => [
                'required',
                'max:500'
            ],
            'ean13' => [
                'sometimes',
            ],
            'id_payment' => [
                'sometimes',
            ],
            'itf14' => [
                'sometimes',
            ],
        ];
    }
}
