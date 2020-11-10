<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product;
use App\Http\Requests\Admin\JsonFormRequest;

class RestoreRequest extends JsonFormRequest
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
            'sku' => [
                'required',
                'max:30',
                function ($attribute, $value, $fail) {
                    if(Product::withTrashed()->whereSku($value)->count() <= 0) {
                        $fail('unique.sku');
                        return;
                    }
                },
            ],
        ];
    }
}
