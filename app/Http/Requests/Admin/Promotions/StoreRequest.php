<?php

namespace App\Http\Requests\Admin\Promotions;

use App\Http\Requests\Admin\JsonFormRequest;
use App\Models\Admin\Client;

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
            'name' => [
                'required',
            ],
            'start' => [
                'required',
                'date_format:Y-m-d',
            ],
            'end' => [
                'required',
                'date_format:Y-m-d',
            ],
            'id_client' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(Client::whereId($value)->count() <= 0) {
                        $fail('exist.id_client');
                        return;
                    }
                },
            ],
             'description' => [
                'sometimes:max255',
            ]
        ];
    }
}
