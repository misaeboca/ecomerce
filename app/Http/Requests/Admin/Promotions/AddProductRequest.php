<?php

namespace App\Http\Requests\Admin\Promotions;

use App\Http\Requests\Admin\JsonFormRequest;
use App\Models\Admin\Product;
use App\Models\Admin\Promotion;

class AddProductRequest extends JsonFormRequest
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
                    if(Promotion::whereId($value)->count() < 1) {
                        $fail('invalid.id_promotion');
                        return;
                    }
                },
            ],
            'products' => [
                'required',
                function ($attribute, $value, $fail) {
                    foreach($value as $v) {
                        if(Product::whereSku($v['sku'])->count() <= 0) {
                            $fail('products.invalid.sku');
                            return;
                        }
                    }
                },
            ],
        ];
    }
}
