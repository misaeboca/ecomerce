<?php

namespace App\Http\Requests\Admin\Auth;

use App\Models\Admin\User;
use App\Http\Requests\Admin\JsonFormRequest;

class LogoutRequest extends JsonFormRequest
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
            'device' => 'sometimes|min:12'
        ];
    }
}
