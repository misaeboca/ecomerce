<?php

namespace App\Http\Requests\Admin\Share;

use App\Models\Admin\ShareType;
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
            'id_share_type' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(ShareType::where('id',$value)->count() <= 0) {
                        $fail('exist.ushtc');
                        return;
                    }
                },
            ],
            'json' => [
                'required'
            ]
        ];
    }
}
