<?php

namespace App\Http\Requests\Common\Banner;

use App\Http\Requests\Common\JsonFormRequest;
use App\Models\Admin\Store;

class ListRequest extends JsonFormRequest
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
                    if(Store::whereId($value)->count() <= 0) {
                        $fail('exist.usc');
                        return;
                    }
                },
            ]
        ];
    }
}
