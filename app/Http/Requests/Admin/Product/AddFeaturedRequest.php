<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product;
use App\Models\Admin\Store;
use App\Http\Requests\Admin\JsonFormRequest;

class AddFeaturedRequest extends JsonFormRequest
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
                'max:30',
                function ($attribute, $value, $fail) {
                    if(Store::whereId($value)->count() <= 0) {
                        $fail('unique.usc');
                        return;
                    }
                },
            ],
            'group' => [
                'required',
            ],
            'products' => [
                'required',
                function ($attribute, $value, $fail) {
                    foreach($value as $v) {
                        if(!isset($v['sku'])) {
                            $fail('product.invalid.sku');
                            return;
                        }
                        else if(Product::whereSku($v['sku'])->count() < 1) {
                            $fail('product.unique.sku');
                            return;
                        }
                    }

                },
            ],
        ];
    }
}
