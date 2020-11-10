<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\Admin\Category;
use App\Http\Requests\Admin\JsonFormRequest;
use App\Models\GlobalStatus;
use Illuminate\Validation\Rule;

class StatusRequest extends JsonFormRequest
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
                'max:30',
                function ($attribute, $value, $fail) {
                    if(Category::whereId($value)->count() <= 0) {
                        $fail('unique.id');
                        return;
                    }
                },
            ],
            /*'status' => [
                'required',
                Rule::in([GlobalStatus::STATUS_ACTIVE, GlobalStatus::STATUS_ACTIVE])
            ]*/
        ];
    }
}
