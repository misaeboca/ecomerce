<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Admin\ProductCategory;
use App\Http\Requests\Admin\JsonFormRequest;
use App\Models\Admin\Product;

class DeleteCategoryRequest extends JsonFormRequest
{
    protected $productSku = '';
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
                        $fail('exist.sku');
                        return;
                    }
                    $this->productSku = $value;
                },
            ],
            'id_category' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(ProductCategory::whereIdCategory($value)->whereProduct($this->productSku)->count() < 1) {
                        $fail('invalid.id_category');
                        return;
                    }
                },
            ],
        ];
    }
}
