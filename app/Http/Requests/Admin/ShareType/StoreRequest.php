<?php

namespace App\Http\Requests\Admin\ShareType;

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
            'name' => [
                'required',
                'max:255'
            ],
            'description' => [
                'required',
                'max:5000'
            ],
            'preview' => [
                'required',
            ]
        ];
    }
}
