<?php

namespace App\Http\Requests\Common\Promotion;

use App\Http\Requests\Common\JsonFormRequest;
use App\Models\Common\Store;

class GetRequest extends JsonFormRequest
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
                        $fail('invalid.id');
                    }
                },
            ],
        ];
    }
}
