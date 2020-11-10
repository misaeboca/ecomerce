<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Http\Requests\Admin\JsonFormRequest;

class AddCategoryRequest extends JsonFormRequest
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
            'id_category' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(Category::whereId($value)->count() < 1) {
                        $fail('invalid.id_category');
                        return;
                    }
                },
            ],
        ];
    }
}
