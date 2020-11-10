<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product;
use App\Http\Requests\Admin\JsonFormRequest;

class AddImageRequest extends JsonFormRequest
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
                        $fail('unique.product');
                        return;
                    }
                },
            ],
            'urls' => [
                'required',
                function ($attribute, $value, $fail) {
                    foreach($value as $v) {
                        if(!isset($v['url'])){
                            $fail('required.url');
                        }
                    }
                },
            ],
            'cod' => [
                'sometimes',
                'max:30'
            ],
            'sku' => [
                'sometimes',
                'max:30'
            ],
        ];
    }
}
