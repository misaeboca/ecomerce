<?php

namespace App\Http\Requests\Admin\Auth;

use App\Models\Admin\User;
use App\Http\Requests\Admin\JsonFormRequest;

class ResetRequest extends JsonFormRequest
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
            'username' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(User::whereUsername($value)->orWhere('email',$value)->count() == 0) {
                        $fail('invalid.username');
                        return;
                    }
                },
            ]
        ];
    }
}
