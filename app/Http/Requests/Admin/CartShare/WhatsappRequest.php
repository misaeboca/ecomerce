<?php

namespace App\Http\Requests\Admin\CartShare;

use App\Http\Requests\Admin\JsonFormRequest;
use App\Models\Admin\Store;

class WhatsappRequest extends JsonFormRequest
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
                        $fail('exist.id_store');
                        return;
                    }
                },
            ]
        ];
    }
}
