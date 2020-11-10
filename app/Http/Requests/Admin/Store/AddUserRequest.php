<?php

namespace App\Http\Requests\Admin\Store;

use App\Models\Admin\Store;
use App\Models\Admin\User;
use App\Http\Requests\Admin\JsonFormRequest;

class AddUserRequest extends JsonFormRequest
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
                function ($attribute, $value, $fail) {
                    if(Store::whereId($value)->count() < 1) {
                        $fail('invalid.id_order');
                    }
                },
            ],
            'username' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if(count(explode(' ', $value)) > 1) {//Verificacion de nombre de usuario unico
                        $fail('invalid.username');
                        return;
                    }

                    if(User::whereUsername($value)->count() > 0) {//Verificacion de nombre de usuario unico
                        $fail('unique.username');
                        return;
                    }
                },
            ],
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if(User::whereEmail($value)->count() > 0) {//Verificacion de correo unico
                        $fail('unique.email');
                        return;
                    }
                },
            ],
            'password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(strlen($value) < 8) {//Verificacion de caracteres minimo
                        $fail('min.password');
                        return;
                    }
                },
            ],
            'whatsapp' => [
                'required',
            ]
        ];
    }
}
