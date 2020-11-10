<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\Admin\Category;
use App\Http\Requests\Admin\JsonFormRequest;

class UpdateRequest extends JsonFormRequest
{
    protected $usc = '';
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
                    if(Category::whereId($value)->count() <= 0) {
                        $fail('exist.name');
                        return;
                    }
                },
            ],
            'name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if(Category::whereName($value)->count() > 0) {
                        $fail('unique.name');
                        return;
                    }
                },
            ],
            'id_category' => [
                'sometimes',
                function ($attribute, $value, $fail) {
                    if(Category::whereId($value)->count() <= 0) {
                        $fail('exist.name');
                        return;
                    }
                },
            ]
        ];
    }
}
