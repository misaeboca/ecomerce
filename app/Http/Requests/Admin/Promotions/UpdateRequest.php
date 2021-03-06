<?php

namespace App\Http\Requests\Admin\Promotions;

use App\Models\Admin\Share;
use App\Models\Admin\ShareType;
use App\Http\Requests\Admin\JsonFormRequest;

class UpdateRequest extends JsonFormRequest
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
            'id_share_type' => [
                'sometimes',
                function ($attribute, $value, $fail) {
                    if(ShareType::whereUshtc($value)->count() <= 0) {
                        $fail('exist.ushtc');
                        return;
                    }
                },
            ],
            'json' => [
                'required',
                'max:5000'
            ]
        ];
    }
}
