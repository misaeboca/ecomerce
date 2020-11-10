<?php

namespace App\Http\Requests\Admin\Store;

use App\Models\Admin\Store;
use App\Http\Requests\Admin\JsonFormRequest;

class StatusRequest extends JsonFormRequest
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
                'max:30',
                function ($attribute, $value, $fail) {
                    if(Store::whereId($value)->count() <= 0) {
                        $fail('unique.id_store');
                        return;
                    }
                },
            ]
        ];
    }
}
