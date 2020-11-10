<?php

namespace App\Http\Requests\Admin\Banner;

use App\Models\Admin\Store;
use App\Http\Requests\Admin\JsonFormRequest;

class StoreRequest extends JsonFormRequest
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
            /*'id_store' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(Store::whereId($value)->count() <= 0) {
                        $fail('exist.usc');
                        return;
                    }
                },
            ],*/
            'file' => [
                'required'
            ],
        ];
    }
}
