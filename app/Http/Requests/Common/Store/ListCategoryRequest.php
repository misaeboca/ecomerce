<?php

namespace App\Http\Requests\Common\Store;

use App\Http\Requests\Common\JsonFormRequest;
use App\Models\Common\Category;
use App\Models\Admin\Store;

class ListCategoryRequest extends JsonFormRequest
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
                function ($attribute, $value, $fail) {
                    if(Store::whereId($value)->count() < 1) {
                        $fail('invalid.id_store');
                    }
                },
            ],
            'category' => [
                'required',
                function ($attribute, $value, $fail) {
                    $params = explode('/', $value);
                    foreach($params as $param)
                    {
                        $cat = Category::whereSlug($param)->first();

                        if(is_null($cat)) {
                            $fail('invalid.category.' . $param);
                            return;
                        }

                    }
                },
            ],
        ];
    }
}
