<?php

namespace App\Http\Requests\Common;

use App\Http\Requests\Admin\JsonFormRequest;

class VerifyRequest extends JsonFormRequest
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
            'cep' => [
                'sometimes'
            ]
        ];
    }
}
