<?php

namespace App\Http\Requests\Common\Click;

use App\Models\Admin\Store;
use App\Http\Requests\Common\JsonFormRequest;
use Illuminate\Validation\Rule;

class SetClickRequest extends JsonFormRequest
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
                        $fail('invalid.id');
                    }
                },
            ],
            'type' => [
                'required',
                Rule::in(['visit', 'product'])
            ],
        ];
    }
}
