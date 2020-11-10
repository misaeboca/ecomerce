<?php

namespace App\Http\Requests\Admin\Store;

use App\Models\Admin\Store;
use App\Models\Admin\StoreLoggi;
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
            'sigla' => [
                'required',
                function ($attribute, $value, $fail) {
                    if(Store::whereId($value)->count() < 1) {
                        $fail('invalid.id_store');
                        return;
                    }

                    $this->usc = $value;
                },
            ],
            'name' => [
                'sometimes',
                'max:255',
                function ($attribute, $value, $fail) {
                    if(Store::whereName($value)->count() > 0) {
                        $fail('unique.name');
                        return;
                    }
                },
            ],
            'address' => [
                'sometimes',
                'max:255'
            ],
            'cep' => [
                'required',
                'max:255'
            ],
            'country' => [
                'sometimes',
                'max:255'
            ],
            'city' => [
                'sometimes',
                'max:255'
            ],
            'email' => [
                'sometimes',
                'email'
            ],
            'phone' => [
                'sometimes',
                'max:30'
            ],
            'logo' => [
                'sometimes',
                'max:5000'
            ],
            'coordinates' => [
                'sometimes',
                'max:5000'
            ],
            'google_tag_manager' => [
                'sometimes',
                'max:50'
            ],
            'google_tag_manager_body' => [
                'sometimes',
                'max:50'
            ],
            'loggi' => [
                'sometimes',
                function ($attribute, $value, $fail)
                {
                    if(!isset($value['user'])) {
                        $fail('loggi.invalid.user');
                        return;
                    }

                    if(StoreLoggi::whereUser($value['user'])->count() > 0) {
                        $fail('loggi.unique.user');
                        return;
                    }

                    if(!isset($value['password'])) {
                        $fail('loggi.invalid.password');
                        return;
                    }

                    if(!isset($value['distance'])) {
                        $fail('loggi.invalid.distance');
                        return;
                    }

                    if($value['distance'] < 0) {
                        $fail('loggi.min.distance');
                        return;
                    }
                },
            ],
            'schedules' => [
                'sometimes',
                function ($attribute, $value, $fail)
                {
                    if(!isset($value['monday_opening']))
                    {
                        $fail('schedules.monday_opening');
                        return;
                    }

                    if(!isset($value['monday_closing']))
                    {
                        $fail('schedules.monday_closing');
                        return;
                    }

                    if(!isset($value['tuesday_opening']))
                    {
                        $fail('schedules.tuesday_opening');
                        return;
                    }

                    if(!isset($value['tuesday_closing']))
                    {
                        $fail('schedules.tuesday_closing');
                        return;
                    }

                    if(!isset($value['wednesday_opening']))
                    {
                        $fail('schedules.wednesday_opening');
                        return;
                    }

                    if(!isset($value['wednesday_closing']))
                    {
                        $fail('schedules.wednesday_closing');
                        return;
                    }

                    if(!isset($value['thursday_opening']))
                    {
                        $fail('schedules.thursday_opening');
                        return;
                    }

                    if(!isset($value['thursday_closing']))
                    {
                        $fail('schedules.thursday_closing');
                        return;
                    }

                    if(!isset($value['friday_opening']))
                    {
                        $fail('schedules.friday_opening');
                        return;
                    }

                    if(!isset($value['friday_closing']))
                    {
                        $fail('schedules.friday_closing');
                        return;
                    }

                    if(!isset($value['saturday_opening']))
                    {
                        $fail('schedules.saturday_opening');
                        return;
                    }

                    if(!isset($value['saturday_closing']))
                    {
                        $fail('schedules.saturday_closing');
                        return;
                    }
                    if(!isset($value['sunday_opening']))
                    {
                        $fail('schedules.sunday_opening');
                        return;
                    }

                    if(!isset($value['sunday_closing']))
                    {
                        $fail('schedules.sunday_closing');
                        return;
                    }

                }
            ]
        ];
    }
}
