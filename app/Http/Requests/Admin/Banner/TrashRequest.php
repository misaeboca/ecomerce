<?php

namespace App\Http\Requests\Admin\Banner;

use App\Models\Admin\Share;
use App\Http\Requests\Admin\JsonFormRequest;

class TrashRequest extends JsonFormRequest
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
            'id_share' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(Share::whereUshc($value)->count() < 1) {
                        $fail('invalid.ushc');
                        return;
                    }
                },
            ],
        ];
    }
}
